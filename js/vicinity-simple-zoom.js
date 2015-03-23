function ready(fn) {
  if (document.readyState != 'loading'){
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}

(ready(function image_zoom() {
  function objectMerge() {
    var out = out || {};
    for (var i = 1; i < arguments.length; i++) {
      if (!arguments[i])
        continue;

      for (var key in arguments[i]) {
        if (arguments[i].hasOwnProperty(key))
          out[key] = arguments[i][key];
      }
    }
    return out;
  }

  var images = document.getElementsByClassName("vicinity-simple-zoom");

  var options_defaults = {
    "cursor-plus": 'url(/wp-content/themes/Rocketclowns-Salient-Child/images/plus.ico)', 
    "cursor-min": 'url(/wp-content/themes/Rocketclowns-Salient-Child/images/minus.ico)', 
    "max-height": '750px', 
  }
  
  for (var i = 0; i < images.length; i++) {
    var img = images[i];

    if ( img.dataset.zoom ) {
      var options = objectMerge({}, options_defaults, 
        JSON.parse(img.dataset.zoom));
    } else {
      var options = options_defaults; 
    }

    img.style["max-height"] = options["max-height"];
    img.style["cursor"] = options["cursor-plus"];
    img.dataset["zoomstatus"] = "small"; 
    img.addEventListener("click", function(e) {
      if ( this.dataset["zoomstatus"] === "small" ) {
        img.style["max-height"] = null;
        img.parentNode.style["cursor"] = options["cursor-min"] + ", zoom-out";
        img.dataset["zoomstatus"] = "zoomed"; 
      } else if ( this.dataset["zoomstatus"] === "zoomed" ) {
        img.style["max-height"] = options["max-height"];
        img.parentNode.style["cursor"] = options["cursor-plus"] + ", zoom-in";
        img.dataset["zoomstatus"] = "small"; 
      }
    });
  }
}));
  

