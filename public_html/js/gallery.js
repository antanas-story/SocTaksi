$(function() {
    $(".mosaic a").bind("click", function(event) {        
        event.preventDefault();
        gallery.show($(this).attr("href"));
    });
});

var gallery = {
    mainPic: null,
    currentPic: null,
    total: 0,
    counter: 1,
    counterSpan: null
}
gallery.show = function (picid) {
    var self = this;
    $(".mosaic").hide();
    $(".gallery").show();
    total = $(".gallery .pictures").children().length;
    mainPic = $(".gallery .mainpic");
    counter = picid;
    counterSpan = $(".gallery .counter");
    currentPic = $("#pic-"+picid);
    self.gotoPic();
    
    $(".gallery .next, .gallery .mainpic").click(function(e) {
        e.preventDefault();
        var next = currentPic.next();
        counter++;
        if(next.length==0) {
            counter = 1;
            next = currentPic.parent().children().first();
        }
        currentPic = next;
        self.gotoPic();
        //console.log("next", next);
    });
    $(".gallery .prev").click(function(e) {
        e.preventDefault();
        var prev = currentPic.prev();
        counter--;
        if(prev.length==0) {
            counter = total;
            prev = currentPic.parent().children().last();
        }
        currentPic = prev;
        self.gotoPic();
        //console.log("prev", prev);
    });
}
gallery.gotoPic = function () {
    var src = currentPic.val();
    mainPic.attr("src", src);
    //console.log("going to pic", src, );
    counterSpan.html(counter + "/" + total);
}