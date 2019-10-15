(function ($) {

    var defaults = {
        div: '<div class="dropdown bts_dropdown"></div>',
        buttontext: 'Maak een keuze',
        button: '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span></span> <i class="caret"></i></button>',
        ul: '<ul class="dropdown-menu"></ul>',
        li: '<li><label></label></li>'
    };

    $.fn.treeselect = function (options) {
        var $select = $(this);

        var settings = $.extend(defaults, options);

        var $div = $(settings.div);
        var $button = $(settings.button);
        var $ul = $(settings.ul).click(function (e) {
            e.stopPropagation();
        });

        initialize();

        function initialize() {
            $select.after($div);
            $div.append($button);
            $div.append($ul);

            createList();
            updateButtonText();

            $select.remove();
        }

        function createStructure(selector) {
            var options = [];

            $select.children(selector).each(function (i, el) {
                $el = $(el);

                options.push({
                    value: $el.val(),
                    text: $el.text(),
                    checked: $el.attr('selected') ? true : false,
                    children: createStructure('option[data-parent=' + $el.val() + ']')
                });
            });

            return options;
        }

        function createListItem(option) {
            var $li = $(settings.li);
            $label = $li.children('label');
            $label.text(option.text);

            if ($select.attr('multiple')) {
                $input = $('<input type="checkbox" name="' + $select.attr('name').replace('[]','') + '[]" value="' + option.value + '">');
            } else {
                $input = $('<input type="radio" name="' + $select.attr('name') +'" value="' + option.value + '">');
            }


            if (option.checked)
                $input.attr('checked', 'checked');
            $label.prepend($input);

            $input.change(function () {
                updateButtonText();
            });

            if (option.children.length > 0) {
                $(option.children).each(function (i, child) {
                    $childul = $('<ul></ul>').appendTo($li);
                    $childul.append(createListItem(child));
                });
            }

            return $li;
        }

        function createList() {
            $(createStructure('option:not([data-parent])')).each(function (i, option) {
                $li = createListItem(option);
                $ul.append($li);
            });
        }

        function updateButtonText() {
            buttontext = [];

            $div.find('input').each(function (i, el) {
                $checkbox = $(el);
                if ($checkbox.is(':checked')) {
                    buttontext.push($checkbox.parent().text());
                }
            });

            if (buttontext.length > 0) {
                if (buttontext.length < 4) {
                    $button.children('span').text(buttontext.join(', '));
                } else if ($div.find('input').length == buttontext.length) {
                    $button.children('span').text('All items selected');
                } else {
                    $button.children('span').text(buttontext.length + ' items selected');
                }
            } else {
                $button.children('span').text(settings.buttontext);
            }
        }
    };
}(jQuery));
