<style type="text/css" media="screen">
    .div-percent-18-29 {
        margin: auto; border-radius: 30px; width: 400px; background-color: #808080;padding: 3px;
    }
    .div-percent-30-49 {
        margin: auto; border-radius: 30px; width: 400px; background-color: #FFC000;padding: 3px;
    }
    .div-percent-50-64 {
        margin: auto; border-radius: 30px; width: 400px; background-color: #A5A5A5;padding: 3px;
    }
    .div-percent-65 {
        margin: auto; border-radius: 30px; width: 400px; background-color: #C55A11;padding: 3px;
    }
    .dashboard-div-age-gap {
        margin: auto; width: 400px;padding: 3px; color: #686868;
    }
    .div-background-white {
        margin: auto; width: 400px; padding: 3px;
    }
    .circle-large {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      font-size: 33px;
      color: #5F6063;
      line-height: 150px;
      text-align: center;
      border: 7px solid #C4580D;
    }
    .circle-small-1 {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      font-size: 33px;
      color: #000;
      line-height: 100px;
      text-align: center;
      border: 3px solid #BFBFBF;
      position: relative;
    }
    .circle-small-1-top {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        font-size: 15px;
        color: #5F6063;
        line-height: 45px;
        text-align: center;
        border: 3px solid #BFBFBF;
        /*margin-left: 14%;*/
        top: -24%;
        left: 82%;
        position: absolute;
    }
    .circle-small-2 {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      font-size: 33px;
      color: #000;
      line-height: 100px;
      text-align: center;
      border: 3px solid #FEC003;
      position: relative;
    }
    .circle-small-2-top {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      font-size: 15px;
      color: #5F6063;
      line-height: 45px;
      text-align: center;
      border: 3px solid #BFBFBF;
      top: -24%;
        left: 82%;
        position: absolute;
    }

    .progress-circle {
  font-size: 20px;
  margin: 20px;
  position: relative;
  /* so that children can be absolutely positioned */
  padding: 0;
  width: 5em;
  height: 5em;
  background-color: #F2E9E1;
  border-radius: 50%;
  line-height: 5em;
  margin: 0px auto;
}

.progress-circle:after {
  border: none;
  position: absolute;
  top: 0.35em;
  left: 0.35em;
  text-align: center;
  display: block;
  border-radius: 50%;
  width: 4.3em;
  height: 4.3em;
  background-color: white;
  content: " ";
}


/* Text inside the control */

.progress-circle span {
  position: absolute;
  line-height: 5em;
  width: 5em;
  text-align: center;
  display: block;
  color: #5F6063;
  z-index: 2;
}

.left-half-clipper {
  /* a round circle */
  border-radius: 50%;
  width: 5em;
  height: 5em;
  position: absolute;
  /* needed for clipping */
  clip: rect(0, 5em, 5em, 2.5em);
  /* clips the whole left half*/
}


/* when p>50, don't clip left half*/

.progress-circle.over50 .left-half-clipper {
  clip: rect(auto, auto, auto, auto);
}

.value-bar {
  /*This is an overlayed square, that is made round with the border radius,
   then it is cut to display only the left half, then rotated clockwise
   to escape the outer clipping path.*/
  position: absolute;
  /*needed for clipping*/
  clip: rect(0, 2.5em, 5em, 0);
  width: 5em;
  height: 5em;
  border-radius: 50%;
  border: 0.45em solid #808080;
  /*The border is 0.35 but making it larger removes visual artifacts */
  /*background-color: #4D642D;*/
  /* for debug */
  box-sizing: border-box;
}


/* Progress bar filling the whole right half for values above 50% */

.progress-circle.over50 .first50-bar {
  /*Progress bar for the first 50%, filling the whole right half*/
  position: absolute;
  /*needed for clipping*/
  clip: rect(0, 5em, 5em, 2.5em);
  background-color: #808080;
  border-radius: 50%;
  width: 5em;
  height: 5em;
}

.value-bar-1 {
  /*This is an overlayed square, that is made round with the border radius,
   then it is cut to display only the left half, then rotated clockwise
   to escape the outer clipping path.*/
  position: absolute;
  /*needed for clipping*/
  clip: rect(0, 2.5em, 5em, 0);
  width: 5em;
  height: 5em;
  border-radius: 50%;
  border: 0.45em solid #FFC000;
  /*The border is 0.35 but making it larger removes visual artifacts */
  /*background-color: #4D642D;*/
  /* for debug */
  box-sizing: border-box;
}


/* Progress bar filling the whole right half for values above 50% */

.progress-circle.over50 .first50-bar-1 {
  /*Progress bar for the first 50%, filling the whole right half*/
  position: absolute;
  /*needed for clipping*/
  clip: rect(0, 5em, 5em, 2.5em);
  background-color: #FFC000;
  border-radius: 50%;
  width: 5em;
  height: 5em;
}

.progress-circle:not(.over50) .first50-bar {
  display: none;
}

.progress-circle:not(.over50) .first50-bar-1 {
  display: none;
}


/* Progress bar rotation position */

.progress-circle.p0 .value-bar {
  display: none;
}
.progress-circle.p32 .value-bar {
  transform: rotate(115deg);
}
.progress-circle.p68 .value-bar {
  transform: rotate(245deg);
}

.progress-circle.p0 .value-bar-1 {
  display: none;
}
.progress-circle.p32 .value-bar-1 {
  transform: rotate(115deg);
}
.progress-circle.p68 .value-bar-1 {
  transform: rotate(245deg);
}
</style>
<br>
<table width="100%">
    <tbody>
        <tr>
            <td style="width: 16%; height: 130px; text-align: left;">
                <div style="width: 150px; height: 10px; border-top: 1px solid #FFBC00; border-left: 4px solid #FFBC00; border-right: 4px solid #FFBC00; margin-top: -77px;"></div>
                <div style="padding-left: 5px; padding-right: 5px;">Overall Membership <br> Reports</div>
                <div style="width: 150px; height: 10px; border-bottom: 1px solid #565656; border-left: 4px solid #565656; border-right: 4px solid #565656;"></div>
            </td>
            <td style="width: 28%; height: 130px;">
                <div class="circle-large" style="margin:0 auto;">295</div>
            </td>
            <td style="width: 28%; height: 130px;">
                
                <div class="progress-circle over50 p68">
                    <span>200</span>
                    <div class="left-half-clipper">
                        <div class="first50-bar"></div>
                        <div class="value-bar"></div>
                    </div>
                    <div class="circle-small-1-top">68%</div>
                </div>
                
            </td>
            <td style="width: 28%; height: 130px;">
                <div class="progress-circle p32">
                    <span>95</span>
                    <div class="left-half-clipper">
                        <div class="first50-bar-1"></div>
                        <div class="value-bar-1"></div>
                    </div>
                    <div class="circle-small-2-top">32%</div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<table width="100%">
    <tbody>
        <tr>
            <td style="width: 16%; text-align: left;">
               
            </td>
            <td style="width: 28%;">
                <div style="margin:0 auto; text-align: center; color: #FFBF13">Monthly Active Meber</div>
            </td>
            <td style="width: 28%;">
                <div style="margin:0 auto;  text-align: center; color: #FFBF13">Wormen</div>
            </td>
            <td style="width: 28%;">
                <div style="margin:0 auto;  text-align: center; color: #FFBF13">Men</div>
            </td>
        </tr>
    </tbody>
</table>
<br>

<table width="100%">
    <tbody>
        <tr>
            <td style="text-align: left;">
                <p class="dashboard-div-age-gap"></p>
                <div class="div-background-white"></div>
            </td>
            <td style="text-align: left;">
                <p class="dashboard-div-age-gap">18-29 years old</p>
                <div class="div-percent-18-29">
                    <div style="width: 44%; border-radius: 30px; background-color: #fff;">
                        <span style="margin-top: 10px; margin-right: 10px; margin-bottom: 10px; margin-left: 44%;">44%</span>
                    </div>
                </div>
            </td>
            <td style="text-align: left;">
                <p style="margin-top: 30px; color: #686868">129</p>
            </td>
        </tr>
        <tr>
             <td style="text-align: left;">
                <p class="dashboard-div-age-gap"></p>
                <div class="div-background-white"></div>
            </td>
            <td style="text-align: left;">
                <p class="dashboard-div-age-gap">18-29 years old</p>
                <div class="div-percent-30-49">
                    <div style="width: 24%; border-radius: 30px; background-color: #fff">
                        <span style="margin-top: 10px; margin-right: 10px; margin-bottom: 10px; margin-left: 30%;">24%</span>
                    </div>
                </div>
            </td>
            <td style="text-align: left;">
                <p style="margin-top: 30px; color: #686868">70</p>
            </td>
        </tr>
        <tr>
             <td style="text-align: left;">
                <p class="dashboard-div-age-gap"></p>
               <div class="div-background-white"></div>
            </td>
            <td style="text-align: left;">
                <p class="dashboard-div-age-gap">50-64 years old</p>
                <div class="div-percent-50-64">
                    <div style="width: 14%; border-radius: 30px; background-color: #fff">
                        <span style="margin-top: 10px; margin-right: 10px; margin-bottom: 10px; margin-left: 25%;">14%</span>
                    </div>
                </div>
            </td>
            <td style="text-align: left;">
                <p style="margin-top: 30px; color: #686868">42</p>
            </td>
        </tr>
        <tr>
             <td style="text-align: left;">
                <p class="dashboard-div-age-gap"></p>
               <div class="div-background-white"></div>
            </td>
            <td style="text-align: left;">
                <p class="dashboard-div-age-gap">65 years old and up</p>
                <div class="div-percent-65">
                    <div style="width: 16%; border-radius: 30px; background-color: #fff">
                        <span style="margin-top: 10px; margin-right: 10px; margin-bottom: 10px; margin-left: 25%;">16%</span>
                    </div>
                </div>
            </td>
            <td style="text-align: left;">
                <p style="margin-top: 30px; color: #686868">54</p>
            </td>
        </tr>
        <tr>
             <td style="text-align: left;">
                <p class="dashboard-div-age-gap"></p>
                <div class="div-background-white"></div>
            </td>
            <td style="text-align: left;">
                
            </td>
            <td style="text-align: left;">
                <p class="dashboard-div-age-gap"></p>
            </td>
        </tr>
    </tbody>
</table>