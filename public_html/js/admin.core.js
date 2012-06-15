var site = {
    msgTimeout:null,
    contentDiv:null,
    locationDiv:null,
    loadingDiv:null,
    messages:null,
    cropperOpen:false,
    JcropObj:{},
    lastTab:{}
}

site.navTo = function(address, post) {
    site.loadingDiv.show();
    var url = address + (address.indexOf("?")==-1 ? "?" : "&") + "ajax" ;
                    
    if(address.indexOf("?")!=-1) {
        location.href = address.replace("?", "#?");
    } else {
        location.href = "#";
    }
    
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].destroy();   
    }
    var type;
    if(post==undefined) {
        post = null;
        type = "GET";
    } else {
        type = "POST";
    }
    $.ajax({
        type: type,
        url: url,
        data: post,
        success: function(data) {
            if(data.charAt(0)!="{") {
                $("#pageerror").slideDown(500);
                site.contentDiv.html(data)
            } else {
                var response = $.parseJSON(data);
                $("#pageerror").hide();
                if(response.redir!=undefined) site.navTo(response.redir);
                else if(response.content==undefined) {
                    site.contentDiv.html(data);
                } else {
                    site.updateLocation(response.location);
                    site.contentDiv.html(response.content);
                    site.afterLoading();
                }
                site.showMessages();
            }
            site.loadingDiv.hide();
        }
    });    

}
site.updateLocation = function(loc) {
    if(loc==undefined) return false;
    var l;
    var html = "";
    var first = true;
    for(var i in loc)  {
        if(first == true) { first = false }
        else { html = html + " &raquo; " }
        l = loc[i];
        html = html + '<a href="'+l.url+'">'+capitaliseFirstLetter(l.name)+'</a>';
    }
    site.locationDiv.html(html);
}
site.showMessages = function() {
    $.getJSON("admin.php?ajax&messages", function(data) {
        if(data!=null) {
            if(data.notify!=null) {
                for(var i in data.notify) {
                    site.messages.notify("create", "notify-template", { text: data.notify[i] }, { custom:true }); 
                }
            }
            if(data.error!=null) {
                for(var i in data.error) {
                    console.log(data.error[i]);
                    site.messages.notify("create", "error-template", { text: data.error[i] }, { expires: false, custom:true }); 
                }
            }            
        }
    });
                /*var msgdiv = $("#messages");
                msgdiv.html(data);
                setTimeout("site.popMessages()",500);*/
    
}
site.popMessages = function () {
    $('#messages').show();
    //$('#messages').show('blind',{},1000);
    clearTimeout(this.msgTimeout);
    this.msgTimeout = setTimeout("$('#messages').hide('blind',{},1000)",20000);
}
site.init = function() {
    site.loadingDiv = $("#loading");
    site.contentDiv = $("#content");
    site.locationDiv = $("#location");                             
    site.messages = $("#messages").notify({ expires: 5000, speed: 500 });
    // nav to somewhere if someone comes from outside
    var loc = location.href;
    if(loc.indexOf("#")!=-1) {
        site.navTo(loc.replace("#", ""));
    }    
    // anchors
    $("a").live('click', function(e) {
        if($(this).hasClass("expand")) {
            if($(this).next().find(".selected").length<=0) {
                $(this).next().slideToggle(500);
            }                
        } else if($(this).hasClass("clone")) {
            var elem = $(this).prev().clone().insertBefore($(this));
            elem.find("input[type='text']").val("");
            elem.find(".hidden").removeClass('hidden');
            e.preventDefault();
        } else {
            var href = $(this).attr("href");
            if(href!=undefined&&href.indexOf("#")==-1&&href.indexOf("admin.php")>=0) {
                if($(this).parent().get(0).nodeName.toLowerCase()=="li") {
                    $("a.selected").removeClass("selected");
                    $(this).addClass("selected");
                }                    
                e.preventDefault();
                site.navTo(href);            
            }
        }
    });
    // forms
    $("form").live('submit', function(e) {
        e.preventDefault();       

        var post = {};
        var action = $(this).attr("action");
        var iters = {};
        $(this).find(":input").each(function() {
            var val = $(this).val();
            var name = $(this).attr("name");
            if( val!=undefined && name!=undefined && name!="") {
                if($(this).hasClass("currency")) val = Math.round(val*100);
                if(name.indexOf("[]")>-1) {
                    iters[name] = iters[name]==undefined ? 0 : iters[name]+1;
                    name = name.replace("[]", "["+iters[name]+"]");
                }
                
                if(!($(this).attr("type")=="checkbox" && !$(this).is(":checked")))
                post[name] = val;
                
            }
        });
        var sort = $(this).find(".sortable");
        if(sort.length>0) {
            var tmp = action.indexOf("?")>0 ? "&" : "?";
            var order = $(this).find(".sortable").sortable('serialize');
            action = action + tmp + order;
        }
        site.log(post);
        site.navTo(action, post);
    });
}
site.log = function(data) {
    if(typeof(console) !== 'undefined' && console != null) {
        console.log(data);
    }
}
site.afterLoading = function() {
    // Init list appearance
    var list = $(".list");
    if(list.length>0) {
        list.find(".row").hover(
            function () {
                $(this).addClass("hover");
            },
            function () {
                $(this).removeClass("hover");
            }
        );
    }
    
    // Category field init
    /*$("#catField").change(function() {
      updateSubcats();  
    }).change();*/
    
    // Button appearance init
    $(".button").button();
    
    // All in one search/filter/order init
    var aioform = $("#aioform");
    if(aioform.length>0) {
        $(".tabs").each(function() {
            var tab = site.lastTab[$(this).attr("id")]!=undefined ? site.lastTab[$(this).attr("id")] : -1;
            $(this).tabs({
                collapsible: true,
                cookie: {
                    expires: 1
                },
                select: function(event, ui) {
                    site.lastTab[$(this).attr("id")] = ui.index;//$(ui.panel).attr("id");
                },
                selected: tab 
            });    
        });
        $(".pagination a").click(function(e) {
            $('#page').val($(this).attr("href"));
            aioform.submit();
            e.preventDefault();
        });
    }

    // Populate address fields
    var example = $("#address-example");
    if(example.length>0) {
        var options = example.find("select").html();
        example.prevAll(".address").find("select").each(function() {
            $(this).html(options);
            $(this).find("option[value='"+$(this).attr("title")+"']").attr("selected", true);
        });
    }
    // Initialize the editor.
    // Callback function can be passed and executed after full instance creation.
    var config = {
        filebrowserUploadUrl: "connector.php"
        //,stylesCombo_stylesSet: "my_styles"
    };
    //config["filebrowserBrowseUrl"] = "browser.php";
    $('.wysiwyg').each(function() {
        config["height"] = $(this).css("height");
        config["width"] = $(this).css("width");
        //config["toolbar"] = $(this).hasClass("extended") ? "Extended" : "General";
       
        //if($.cookie('superadmin')=="yes") {
            config["toolbar"] = 'Admin';
        //}
        $(this).ckeditor(function() { site.log("CKEditor loaded"); }, config);
    });
    
    // Initialize the datpicker fields
    $('.datepicker').datepicker({
        'dateFormat':'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        duration: '',
        firstDay: 1,
        dayNamesMin: ["Se", "Pr", "An", "Tr", "Ke", "Pe", "Še"],
        monthNamesShort: ["Sausis", "Vasaris", "Kovas", "Balandis", "Gegužė", "Birželis", "Liepa", "Rugpjūtis", "Rugsėjis", "Spalis", "Lapkritis", "Gruodis"]
    });    
    $('.datetimepicker').datepicker({
        'dateFormat':'yy-mm-dd 00:00',
        changeMonth: true,
        changeYear: true,
        duration: '',
        firstDay: 1,
        dayNamesMin: ["Se", "Pr", "An", "Tr", "Ke", "Pe", "Še"],
        monthNamesShort: ["Sausis", "Vasaris", "Kovas", "Balandis", "Gegužė", "Birželis", "Liepa", "Rugpjūtis", "Rugsėjis", "Spalis", "Lapkritis", "Gruodis"]
    });
    
    // Mass uploader init
    var submitBtn = $("input[type='submit']");
    var stack = new Array();
    $(".uploadfiles").each(function () {
    	var self = $(this);
        var uploadingMany = self.hasClass("pictures") ? true : false;
        var uploader = new qq.FileUploader({
            // pass the dom node (ex. $(selector)[0] for jQuery users)
            element: $(this)[0],
            // path to server-side upload script
            action: 'upload.php?pictures='+ (uploadingMany ? "1" : "0"),
            multiple: $(this).attr("multiple") == "true" ? true : false,
            onSubmit: function(id, fileName) {
                stack.push(id);
                submitBtn.attr("disabled", true);
            },
            onComplete: function(id, fileName, responseJSON) {
                stack.pop();
                if(stack.length==0) submitBtn.attr("disabled", false);
                $("form").prepend('<input type="hidden" name="'+self.attr("fieldname")+'" value="'+responseJSON.filename+'"/>');                
            },
            onCancel: function(id, fileName) {
                stack.pop();
                if(stack.length==0) submitBtn.attr("disabled", false);
            }
        });
    });
    
    // Picture ordering tool init
    $(".sortable").sortable({ items: 'div.image', handle: '.handle' });
    
    // Divide by two all currency fields
    $(".currency").each(function() {
        site.log($(this).val());
                $(this).val(parseFloat(parseInt($(this).val())/100));
    }).change(function() {
        var parsed = parseFloat($(this).val().replace(",", "."));
        $(this).val(isNaN(parsed)? 0 : parsed);
    }).change();
    site.initAll();
}
site.initAll = function () {};

site.showCropper = function(sourceid) {
    if(site.cropperOpen == true) return;
    
    var container = $("#"+sourceid);
    JcropObj = {};
    site.cropperOpen = true;
    
    container.show();//.css({ position:"absolute", left:"-9999px" });
    container.find(".cropper").each(function() {
        var parent = $(this);
        var img = parent.find(".img");
        var preview = parent.find(".preview");
        var previewimg = parent.find(".preview").find(".previewimg");
        JcropObj[$(this).attr("id")] = {
            id : $(this).attr("id"),
            width : preview.width(),
            height : preview.height(),
            jcrop : $.Jcrop(img, {
                boxWidth: 600,
                boxHeight: 400,
                aspectRatio: preview.width() / preview.height(),
                onChange: function (coords) {
                    if (parseInt(coords.w) > 0) {
                        var rx = preview.width() / coords.w;
                        var ry = preview.height() / coords.h;
                        previewimg.css({
                            width: Math.round(rx * img.width()) + 'px',
                            height: Math.round(ry * img.height()) + 'px',
                            marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                            marginTop: '-' + Math.round(ry * coords.y) + 'px'
                        });
                    }
                },
                onSelect: function(coords) {
                }
            })
        };
    });
    container.find(".croptabs").accordion({
        /*collapsible: true,
        active: false,*/
        autoHeight: false,
        changestart: function(event, ui) { 
        }
    }); 
       
    container.dialog({
        "modal":true,
        "title":"Nuotraukų kadravimas",
        "width":"auto",
        "height":"auto",
        "open": function() {

            //container.css({ "position": "fixed", "top":"50px", "left":"50px" });
        },
        "close": function() {
            for(var obj in JcropObj) {
                JcropObj[obj].jcrop.destroy();
            }
            JcropObj = {};
            /*$(this).find(".cropper").each(function() {
                var api = $.Jcrop( $(this).find(".img:first") );
                api.destroy();
                $(this).find(".jcrop-holder").remove();
                console.log("destroying Jcrop", $(this).attr("id"));
            });*/
            $(this).find(".croptabs").accordion("destroy");
            $(this).dialog("destroy");
            site.cropperOpen = false;
        }
    });
};
/*site.spawnCropper = function(filename, params) {
    var str = "";
    for(var i in params) {
        str +=
            '<h3><a href="#">'+ params[i].caption +'</a></h3>'+
            '<div id="pic-'+ i +'" class="cropper">'+
                '<div>'+
                '<button class="button" onclick="site.cropPic(\'pic-'+ i +'\', \''+ filename +'\', \''+ params[i].prefix +'\');">Išsaugoti</button>'+
                '</div>'+
                '<div class="cropwrap">'+
                    '<img src="images/'+ filename +'" alt="" class="img" />'+
                '</div>'+
                '<span class="preview" data-width="'+params[i].width+'" data-height="'+params[i].height+'" style="width:'+ params[i].width +'px;height:'+ params[i].height +'px;">'+
                    '<img src="images/'+ filename +'" class="previewimg" />'+
                '</span>'+
            '</div>';
    }
    
    return '<div id="picCrop" class="hidden">'+
                '<div class="croptabs">'+
                    str+                                
                '</div>'+
            '</div>';
}*//*
site.showCropper = function(params, filename) {
    if(site.cropperOpen == true) return;
    
    var container = $(site.spawnCropper(filename, params)).appendTo("body");//html();//"#"+sourceid);
    //console.log("container", container);
    var img = container.find("img.img:first");
    var imgObj = new Image();
    
    $(imgObj).load(function() {
        JcropObj = {};
        site.cropperOpen = true;
        //console.log("on window load", params, filename, container);
        container.show();//.css({ position:"absolute", left:"-9999px" });
        container.find(".cropper").each(function() {
            var parent = $(this);
            var img = parent.find(".img");
            var preview = parent.find(".preview");
            var previewimg = parent.find(".preview").find(".previewimg");
            var previewWidth = parseInt(preview.data("width"));
            var previewHeight = parseInt(preview.data("height"));
            
            var params = {
                boxWidth: 600,
                boxHeight: 400,
                onSelect: function(coords) {
                },
                minSize: [10, 10]
            };
            if(previewWidth > 0 && previewHeight > 0) {
                params.aspectRatio = preview.width() / preview.height();
                params.onChange = function (coords) {
                    if (parseInt(coords.w) > 0) {
                        var rx = preview.width() / coords.w;
                        var ry = preview.height() / coords.h;
                        previewimg.css({
                            width: Math.round(rx * img.width()) + 'px',
                            height: Math.round(ry * img.height()) + 'px',
                            marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                            marginTop: '-' + Math.round(ry * coords.y) + 'px'
                        });
                    }
                };
            }
            else if(previewHeight == 0) {
                params.onChange = function (coords) {
                    if (parseInt(coords.w) > 0) {
                        var rx = previewWidth / coords.w;
                        var newH = coords.h * rx;
                        var ry = newH / coords.h;
                        preview.css("height", newH+"px")
                        previewimg.css({
                            width: Math.round(rx * img.width()) + 'px',
                            height: Math.round(ry * img.height()) + 'px',
                            marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                            marginTop: '-' + Math.round(ry * coords.y) + 'px'
                        });
                    }
                };                
            }
            
            
            
            
            JcropObj[$(this).attr("id")] = {
                id : $(this).attr("id"),
                jcrop : $.Jcrop(img, params),
                preview : preview
            };             
        });
        container.dialog({
            "modal":true,
            "title":"Nuotraukų kadravimas",
            "width":"auto",
            "height":"auto",
            "open": function() {

                //container.css({ "position": "fixed", "top":"50px", "left":"50px" });
            },
            "close": function() {
                for(var obj in JcropObj) {
                    JcropObj[obj].jcrop.destroy();
                }
                JcropObj = {};
                $(this).find(".croptabs").accordion("destroy");
                $(this).dialog("destroy");
                $("#picCrop").remove();
                site.cropperOpen = false;
            }
        });
        container.find(".croptabs").accordion({
            /*collapsible: true,
            active: false,W/
            autoHeight: false,
            changestart: function(event, ui) { 
            }
        });
        $(".button").button();        
    })
    .attr("src", img.attr("src"));
}                                */           
site.cropPic = function (id, filename, prefix) {
    site.loadingDiv.show();
    var curr = JcropObj[id];
    var post = curr.jcrop.tellSelect();
    if(post.w<=0) { alert("Prieš saugodami pažymėkite plotą, kurį norite iškirpti."); return; }
    post["filename"] = filename;
    post["prefix"] = prefix;
    
    post["destw"] = curr.preview.width();
    post["desth"] = curr.preview.height();
    $.post("cropper.php", post, function() {
        site.loadingDiv.hide();
        site.showMessages();
    });
}
site.del = function(what, id, anchor) {
    /*$.get("admin.php?ajax&what="+from+"&delete="+id, function(response) {
        if(response=="1") {
            $(anchor).parent().remove();
        }
        site.showMessages();
    });*/
    if(confirm("Ar tikrai?")) {
        site.navTo("admin.php?ajax&p="+what, {what:what, action:"del", id:id});
    };
    
}
function capitaliseFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
$(function() {
    site.init();
    site.showMessages();
    
});
/*
function clonePicField(self) {
    var f = $("#picUpload");
    f.clone().attr("id", "").val("").insertBefore($(self)).focus();
}*/