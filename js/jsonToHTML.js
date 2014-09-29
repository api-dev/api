function jsonToHTML(json) {

    var parseJSON = {
        html: "",
        data: [],
        ok_properties: ["background", "border-bottom", "border-left", "border-right", "border-top", "width", "padding"],
        init: function() {
            var content = "";
            for (var i = 0; i < json.length; i++) {
                json[i] = JSON.stringify(json[i]);
                json[i] = JSON.parse(json[i]);
                this.data[i] = json[i];
                content += "{content " + this.data[i].id + "}";
            }
            this.html = "<html><head></head><body style=\"margin:auto\">" + content + "</body></html>";
            for (var i = 0; i < json.length; i++) {
                this.go(this.data[i]);
            }
            return this.html;
        },
        replace: function(obj) {
            var style = "",
                    templ = "",
                    img_src = "",
                    regexp_cont = new RegExp("\{content " + obj.id + "\}", "g");

            for (property in obj.style) {
                if (obj.type === "block" || "page") {
                   if (this.ok_properties.indexOf(property) >= 0) {
                        if ((property === "width") && (obj.type === "block") && (obj.style[property].indexOf("%") !== -1)) {
                            style += property + ":100%;";
                        }
                        else {
                            style += property + ":" + obj.style[property] + ";";
                        }
                 }
                   
                }
                else {
                    style += property + ":" + obj.style[property] + ";";
                }
            }

            switch (obj.type) {
                case "page":
                    templ = "<table width=\"800\" bgcolor=\"#eeeeee\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"border: 0; border-collapse: collapse;\">";
                    for (var i = 0; i < obj.content.length; i++) {
                        templ += "<tr valign=\"top\"><td style=\"padding:0px 20px;\" width=\"" + obj.content[i].style['width'] + "\">{content " + obj.content[i].id + "}</td></tr>";
                    }
                    templ += "</table>";
                    break
                case "block":
                    templ = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"" + style + "\"><tr valign=\"top\">";
                    if (obj.content.length !== 0) {
                        // if contains structure of blocks
                        if (obj.content[0].type === "block") {
                            total_size = 0;
                            temp_size = 0;
                            for (var i = 0; i < obj.content.length; i++) {
                                templ += "<td>{content " + obj.content[i].id + "}</td>";
                            }
                        }
                        //if contains image or text (content)
                        else {
                            
                            for (var i = 0; i < obj.content.length; i++) {
                                templ += "<td valign=\"top\" width=\""+obj.content[i].style.width+"\">{content " + obj.content[i].id + "}</td>";
                            }
                            
                        }
                        
                    }
                    else {
                        templ += "<td></td>";
                    }
                    templ += "</tr></table>";
                    break
                case "string":
                    templ = "<p style=\"margin:0; padding: 0;" + style + "\">" + obj.content + "</p>";
                    break
                case "image":
                    img_src = obj.content.src;
                    templ = "<img src=\"" + img_src + "\" style=\"" + style + "\">";
                    break
                case "varible":
                    templ = "<span style=\"" + style + "\">$data['" + obj.content.substr(1,obj.content.length-1) + "'];</span>";
                    break
            }
            ;

            this.html = this.html.replace(regexp_cont, templ);
            
            return this;

        },
        go: function(obj) {
            this.replace(obj);
            if ((Object.prototype.toString.call([obj.content]) === '[object Array]') && (typeof obj.content !== 'string') && (obj.content.length > 0)) {
                for (var i = 0; i < obj.content.length; i++) {
                    this.go(obj.content[i]);
                }
            }
            else {
                return this.html;
            }

        }

    };
    return parseJSON.init();


}


