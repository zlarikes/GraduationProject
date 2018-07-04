(function ($) {
          $.fn.hAccordion = function (options) {
            $.fn.hAccordion.defaults = {
              "width":600,
                    //运动的元素的总宽度，包括边框和padding
                    "titleWidth": 60,
                    //显示标题的宽度
                    "iNow": 1,
                    //当前显示的是那个元素，最小取值为1
                    "speed": 400, //运动的快慢单位是毫秒
                    "easing":"easeOutQuad"
                  };
                  var opts = $.extend({}, $.fn.hAccordion.defaults, options || {});
                  if(jQuery.easing.def){
                   jQuery.easing.def = opts.easing;
                 }
                //
                return this.each(function () {
                  var $this = $(this);
                  var aEle = $this.children();
                  var len = aEle.length;
                  var iW = opts.width - opts.titleWidth;
                  var iNow = opts.iNow > len ? len : opts.iNow < 1 ? 1 : opts.iNow;
                  var gap = opts.titleWidth;
                  var timer = null;
                    //计算出
                    $this.width((len - 1) * gap + opts.width);
                    //渲染方法
                    function render() {
                      aEle.each(function (i, element) {
                        if (i < iNow) {
                          $(this).animate({
                            "left": i * gap + "px"
                          }, opts.speed);
                        } else {
                          $(this).animate({
                            "left": (i * gap) + iW + "px"
                          }, opts.speed);
                        }
                      });
                    };
                    //初始化
                    render();
                    //鼠标移到事件
                    aEle.unbind("mouseenter").bind("mouseenter", function () {
                      var $$this = $(this);
                      clearTimeout(timer);
                      timer = setTimeout(function(){
                        iNow = $$this.index() + 1;
                        $$this.addClass("curr").siblings().removeClass("curr");
                        render();
                      },100);
                    });
                  });
              }
            })(jQuery);

            $(function(){
             $("#hAcc").hAccordion({
              width:600,
              titleWidth:40,
              iNow : 1,
              speed:400,
              easing:"easeOutBounce"
            });
           })