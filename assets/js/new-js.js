$(document).ready(function() {
var transition_time=(typeof $(".fx-slides").data('transition') !== "undefined") ? parseInt($(".fx-slides").data('transition')) * 1000 : 10000;
setInterval(function () {
  var check=$(".slide-show").next('.slide-data');
      check=check.length > 0 ? check : $(".slide-data").first();
  if(check.length > 0) {
    $(".slide-data").removeClass('slide-show d-none slide-right');
    if(check.prev('.slide-data').length === 0) {
    $(".slide-data").last().addClass('slide-right');
setTimeout(function () {
      $(".slide-data").last().addClass('d-none').removeClass('slide-right');
}, 2000);
    }else {
    check.prev().addClass('slide-right');
setTimeout(function () {
    check.prev().addClass('d-none').removeClass('slide-right');
}, 2000);
    }
    check.addClass('slide-show');
  }
}, transition_time);

// $('.slide-control-left').on('click',function() {
//
// });
// $('.slide-control-right').on('click',function() {
//
// });

$('.pms-rpr').on('change',function() {
var split_link=window.location.href.split("?");
window.location = split_link[0]+"?limit="+$(this).val();
});

function search_loop(to_search, data) {
    var regex_search = new RegExp(to_search, "gi");
    if (data.match(regex_search) != null) {
        return true;
    }
    return false;
}

function search_in_table(to_search) {
    var t_false = 0;
    var total = 0;
    $(".md-main-table").find('.r_nf_c').detach();
    $(".md-main-table").find(".tb-row").each(function() {
        total++;
        var data = $(this).find(".tb-val").text();
        if (search_loop(to_search, data) == false) {
            t_false++;
            $(this).hide();
        } else {
            $(this).fadeIn("fast");
        }
    });
    if (t_false == total) {
        $(".md-main-table").append('<div class="tb-row r_nf_c"><div class="tb-data fx-col-1"><div class="text-center">No Match Found!</div></div></div>');
    }
}
$(".pms-search-item").off('input').on('input', function() {
        search_in_table($(this).val());
});
});
