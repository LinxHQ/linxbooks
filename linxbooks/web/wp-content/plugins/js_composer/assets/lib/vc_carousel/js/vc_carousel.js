/* ========================================================================
 * VC: carousel.js v0.4.5
 * Fork Bootstrap: carousel.js v3.0.0
 * http://twbs.github.com/bootstrap/javascript.html#carousel
 * ========================================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ======================================================================== */


;(function($) { "use strict";

  // CAROUSEL CLASS DEFINITION
  // =========================

  var Carousel = function (element, options) {
    this.$element    = $(element)
    this.$indicators = this.$element.find('.vc_carousel-indicators')
    this.options     = options
    this.paused      =
    this.sliding     =
    this.interval    =
    this.$active     =
    this.$items      = null
    this.options.pause == 'hover' && this.$element
      .on('mouseenter', $.proxy(this.pause, this))
      .on('mouseleave', $.proxy(this.cycle, this))
    this._build() // new
  }

  Carousel.DEFAULTS = {
    mode: 'horizontal'
  , partial: false
  , interval: 5000
  , pause: 'hover'
  , wrap: false
  , autoHeight: false
  , perView: 1
  }
  Carousel.prototype.cycle =  function (e) {
    e || (this.paused = false)

    this.interval && clearInterval(this.interval)

    this.options.interval
      && !this.paused
      && (this.interval = setInterval($.proxy(this.next, this), this.options.interval))
      this.touch_start_position = 0;
    return this
  }
  Carousel.prototype.getActiveIndex = function () {
    this.$active = this.$element.find('.vc_item.vc_active')
    if(!this.$active.length) this.$active = this.$element.find('.vc_item:first').addClass('vc_active')
    this.$items  = this.$active.parent().children()
    return this.$items.index(this.$active)
  }
  Carousel.prototype.showHideControl = function(index) {
    if(typeof index === 'undefined') var index = this.getActiveIndex()
    this.$left_control[index===0 ? 'hide' : 'show']()
    this.$right_control[index===this.items_count-1 ? 'hide' : 'show']()
  }
  Carousel.prototype.to = function (pos) {
    var that        = this
    var activeIndex = this.getActiveIndex()

    if (pos > (this.$items.length - 1) || pos < 0) return

    if (this.sliding)       return this.$element.one('slid', function () { that.to(pos) })
    if (activeIndex == pos) return this.pause().cycle()

    return this.slide(pos > activeIndex ? 'next' : 'prev', $(this.$items[pos]))
  }

  Carousel.prototype.pause = function (e) {
    e || (this.paused = true)

    if (this.$element.find('.vc_right.vc_carousel-control, .vc_left.vc_carousel-control').length && $.support.transition.end) {
      this.$element.trigger($.support.transition.end)
      this.cycle(true)
    }

    this.interval = clearInterval(this.interval)

    return this
  }

  Carousel.prototype.next = function () {
    if (this.sliding) return
    return this.slide('next')
  }

  Carousel.prototype.prev = function () {
    if (this.sliding) return
    return this.slide('prev')
  }

  Carousel.prototype.slide = function (type, next) {
    var $active   = this.$element.find('.vc_item.vc_active')
    var $next     = next || $active[type]()
    var isCycling = this.interval
    var direction = type == 'next' ? 'vc_left' : 'vc_right'
    var fallback  = type == 'next' ? 'first' : 'last'
    var that      = this
    if (!$next.length) {
      if (!this.options.wrap) {
        this.returnSwipedSlide()
        return
      }
      $next = this.$element.find('.vc_item')[fallback]()
    }

    this.sliding = true

    isCycling && this.pause()

    var e = $.Event('slide.vc.carousel', { relatedTarget: $next[0], direction: direction })

    if ($next.hasClass('vc_active')) return

    if (this.$indicators.length) {
      this.$indicators.find('.vc_active').removeClass('vc_active')
      this.$indicators.find('.vc_partial').removeClass('vc_partial')
      this.$element.one('slid', function () {
        var index = that.getActiveIndex(),
            $nextIndicator = $(that.$indicators.children().slice(index, that.getActiveIndex() + that.options.perView))
        $nextIndicator && $nextIndicator.addClass('vc_active')
        that.options.partial && $nextIndicator && (index+1 < that.items_count ? $nextIndicator.last().next().addClass('vc_partial') : $nextIndicator.first().prev().addClass('vc_partial'))
        !that.options.wrap && that.showHideControl(index)
      })
    }
    this.current_index = $next.index()
    if(this.current_index > this.items_count) {
      this.current_index = 0
    } else if(this.current_index < 0) {
      this.current_index = this.items_count -1
    }
    if(this.options.autoHeight) {
      this.current_pos_value = -1 * this._step * this.current_index
    } else {
      this.current_pos_value = -1 * $next.position()[this.animation_position]
    }
    if(this.options.partial && this.current_index >= this.items_count-1) {
      this.current_pos_value += this._step*(1-this.partial_part)
    }
    if ($.support.transition && this.$element.hasClass('vc_slide')) {
      this.$element.trigger(e)
      if (e.isDefaultPrevented()) return
      this.$slideline_inner
        .addClass('vc_transition')
        .css(this.animation_position,  this.current_pos_value + that.pos_units)
      if(!this.options.autoHeight) this.recalculateSlidelineHeight($next.height(), true)
      this.$slideline_inner.one($.support.transition.end, function(){
        $next.addClass('vc_active')
        $active.removeClass('vc_active')
        that.$slideline_inner.removeClass([type, 'vc_transition'].join(' '))
        that.sliding = false
        that.removeSwipeAnimationSpeed()
        setTimeout(function () { that.$element.trigger('slid') }, 0)
      }).emulateTransitionEnd(this.transition_speed)
    } else {
      this.$element.trigger(e)
      if (e.isDefaultPrevented()) return
      $active.removeClass('vc_active')
      $next.addClass('vc_active')
      this.sliding = false
      this.$slideline_inner.css(this.animation_position, this.current_pos_value + that.pos_units)
    }
    isCycling && this.cycle()
    return this
  }
  Carousel.prototype.setSwipeAnimationSpeed = function() {
    this.$slideline_inner.addClass('vc_swipe-transition')
  }
  Carousel.prototype.removeSwipeAnimationSpeed = function() {
    this.$slideline_inner.removeClass('vc_swipe-transition')

  }
    /**
     * Velocity
     * @param   {Number}    delta_time
     * @param   {Number}    delta_x
     * @param   {Number}    delta_y
     * @returns {Object}    velocity
     */
    Carousel.prototype.velocity =  function(time, x) {
      return {
          x: Math.abs(x / time) || 0
      }
    }
    Carousel.prototype.recalculateSlidelineHeight = function(height, animate) {
      if(animate === true) {
        this.$slideline.animate({height: height})
      } else {
        this.$slideline.height(height)
      }
    }
    /**
     * Change layout size after resizing of window.
     */
    Carousel.prototype.resizeAction = function() {
      var max_height = 0,
          new_slideline_height = 0
      if(this.options.mode === 'horizontal') {
        this.el_effect_size = this.$element.width() * ( this.options.partial ? this.partial_part : 1 )
        this.$slideline.width(this.items_count*this.el_effect_size)
      }

      if (this.options.autoHeight) {
        this.$items.height('auto')
        this.$items.each(function(){
          var item_height = $(this).height()
          if(item_height > max_height) max_height = item_height
        })
        this.$items.height(max_height)
      } else {
        this.recalculateSlidelineHeight(this.$active.height())
      }
      if(this.options.mode === 'vertical') {
        this._step = this.$active.height()
        new_slideline_height = this.$active.height() * this.options.perView * (this.options.partial ? (1 + 1-this.partial_part) : 1)
        this.recalculateSlidelineHeight(new_slideline_height, false)
        this.$slideline_inner.css({top: -1 * this.$active.position().top})
        this.el_effect_size = this._step
      }
    }
    Carousel.prototype.returnSwipedSlide = function() {
      var params = {}
      params[this.animation_position] = this.current_pos_value + this.pos_units
      this.$slideline_inner.animate(params)
    }
    Carousel.prototype._build = function() {
      var el                      = this.$element.get(0),
          _touch_start_position   = false,
          _touch_start_time       = 0,
          _pos_before_touch      = 0,
          _diff                   = 0,
          _moved                  = false,
          that                    = this,
          mode                    = this.options.mode
      this.getActiveIndex()

      this.el_width               = 0
      this.items_count            = this.$items.length

      this.$slideline             = this.$element.find('.vc_carousel-slideline')
      this.$slideline_inner       = this.$slideline.find('> div')
      this.slideline_inner        = this.$slideline_inner.get(0)

      this.partial_part           = 0.8
      this._slide_width           = 0
      this.swipe_velocity         = 0.7
      this.current_pos_value      = 0
      this.current_index          = 0 // TODO: default start position by options
      this.el_effect_size         = 0
      this.transition_speed       = 600

      this.$left_control = this.$element.find('.vc_left.vc_carousel-control')
      this.$right_control = this.$element.find('.vc_right.vc_carousel-control')

      // Enable autoHeight if partial
      if(this.options.partial) this.options.autoHeight = true
      // Add Css classes for perView > 1
      if(this.options.perView > 1) this.$element.addClass('vc_per-view-more vc_per-view-' + this.options.perView)

      if( mode === 'horizontal') {
        this.pos_units = '%'
        this._step = 100.00/this.items_count/this.options.perView
        this.animation_position = 'left'
        this.$items.width(this._step + this.pos_units)
        this.touch_direction = 'pageX'
      } else {
        this.pos_units = 'px'
        this.animation_position = 'top'
        this.touch_direction = 'pageY'
        this.$element.addClass('vc_carousel_vertical')
      }
      // Hide first control if this.current_index === 0
      !that.options.wrap && this.showHideControl()
      // Add partial css class if partial
      if(this.options.partial) this.$element.addClass('vc_partial')
      // Set indicator
      if(this.$indicators.length) {
        var $active_indecators = that.$indicators.children()
                                                 .slice(this.current_index, this.current_index + this.options.perView)
                                                 .addClass('vc_active')
        this.options.partial && $active_indecators.last().next().addClass('vc_partial')
      }
      $(window).resize(this.resizeAction.bind(this)); this.resizeAction()

      el.addEventListener("touchstart", function(e){
        _touch_start_position = parseFloat(e[that.touch_direction])
        _touch_start_time = e.timeStamp
        _pos_before_touch = that.$slideline_inner.position()[that.animation_position]
      }.bind(this), false)
      el.addEventListener('touchmove', function(e){
        _diff = parseFloat(e[that.touch_direction]) - _touch_start_position
        _moved = Math.abs(_diff) > 0
        if(!_moved) return true
        e.preventDefault()
        that.slideline_inner.style[that.animation_position] = (_pos_before_touch + _diff) + 'px'
      }, false)
      el.addEventListener('touchend', function(e){
        var time,part,velocity
        if(_moved) {
          time= (e.timeStamp-_touch_start_time)/1000
          part = _diff/ that.el_effect_size
          velocity = that.velocity(time, part)
          if((velocity.x > that.swipe_velocity && part < 0) || part <= -0.7) {
            that.setSwipeAnimationSpeed()
            that.next()
          } else if(velocity.x > that.swipe_velocity || part >= 0.7) {
            that.setSwipeAnimationSpeed()
            that.prev()
          } else {
            that.returnSwipedSlide()
          }
          _moved = false
        }
      }, false)
      this.$element.addClass('vc_build')
      return this
    }
  // CAROUSEL PLUGIN DEFINITION
  // ==========================

  var old = $.fn.carousel

  $.fn.carousel = function (option, value) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('vc.carousel')
      var options = $.extend({}, Carousel.DEFAULTS, $this.data(), typeof option == 'object' && option)
      var action  = typeof option == 'string' ? option : options.slide

      if (!data) $this.data('vc.carousel', (data = new Carousel(this, options)))
      if (typeof option == 'number') data.to(option)
      else if (action) data[action](value)
      else if (options.interval) data.pause().cycle()
    })
  }

  $.fn.carousel.Constructor = Carousel


  // CAROUSEL NO CONFLICT
  // ====================

  $.fn.carousel.noConflict = function () {
    $.fn.carousel = old
    return this
  }


  // CAROUSEL DATA-API
  // =================

  $(document).off('click.vc.carousel.data-api').on('click.vc.carousel.data-api', '[data-slide], [data-slide-to]', function (e) {
    var $this   = $(this), href
    var $target = $($this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '')) //strip for ie7
    var options = $.extend({}, $target.data(), $this.data())
    var slideIndex = $this.attr('data-slide-to')
    if (slideIndex) options.interval = false
    $target.carousel(options)

    if (slideIndex = $this.attr('data-slide-to')) {
      $target.data('vc.carousel').to(slideIndex)
    }

    e.preventDefault()
  })

  $(window).on('load', function () {
    $('[data-ride="vc_carousel"]').each(function () {
      var $carousel = $(this)
      $carousel.carousel($carousel.data())
    })
  })

})(window.jQuery);
