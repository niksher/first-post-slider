$(document).ready(function(){
    function __init() {
        item();
        buttons();
    }
    
    function item() {
        var url = window.location.pathname + window.location.search + "&status=active";
        $("[name=fps-slider]").on("change", function(){
            var r = $(this).prop("checked");
            var active = "0";
            if (r) {
                active = "1";
            }
            console.log(active);
            $.post(url, {"active": active}, function(data) {
                console.log(data);
                location.reload();
            });
        });
            
    }
    
    function buttons(){
        button_add();
        button_del();
    }
    
    function button_add() {
        $(".fps-post__button").on("click", function() {
            var url = window.location.pathname + window.location.search + "&status=add";
            var post_id = $(this).attr("data-id");
            $.post(url, {"post_id": post_id}, function(data) {
                location.reload();
            });
        });
    }
    
    function button_del() {
        $(".fps-slide__button").on("click", function() {
            var url = window.location.pathname + window.location.search + "&status=del";
            var post_id = $(this).attr("data-id");
            $.post(url, {"post_id": post_id}, function(data) {
                location.reload();
            });
        });
    }
    
    
    
    __init();
});


