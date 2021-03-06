

const $ = require('jquery');
const jQuery = require('jquery');

/* Dore Theme Select & Initializer Script

Table of Contents

01. Css Loading Util
02. Theme Selector And Initializer
*/

/* 01. Css Loading Util */
function loadStyle(href, callback) {
  for (var i = 0; i < document.styleSheets.length; i++) {
    if (document.styleSheets[i].href == href) {
      return;
    }
  }
  var head = document.getElementsByTagName("head")[0];
  var link = document.createElement("link");
  link.rel = "stylesheet";
  link.type = "text/css";
  link.href = href;
  if (callback) {
    link.onload = function() {
      callback();
    };
  }
  head.appendChild(link);
}

/* 02. Theme Selector And Initializer */
(function($) {
  if ($().dropzone) {
    Dropzone.autoDiscover = false;
  }
  
  var themeColorsDom = '';
  $("body").append(themeColorsDom);
  var theme = "dore.css";

  if (typeof Storage !== "undefined") {
    if (localStorage.getItem("theme")) {
      theme = localStorage.getItem("theme");
    }
  }

  $(".theme-color[data-theme='" + theme + "']").addClass("active");

  loadStyle("/build/" + theme, onStyleComplete);
  function onStyleComplete() {
    setTimeout(onStyleCompleteDelayed, 300);
  }

  function onStyleCompleteDelayed() {
    var $dore = $("body").dore();
  }

  $("body").on("click", ".theme-color", function(event) {
    event.preventDefault();
    var dataTheme = $(this).data("theme");
    if (typeof Storage !== "undefined") {
      localStorage.setItem("theme", dataTheme);
      window.location.reload();
    }
  });


  $(".theme-button").on("click", function(event) {
    event.preventDefault();
    $(this)
      .parents(".theme-colors")
      .toggleClass("shown");
  });
  $(document).on("click", function(event) {
    if (
      !(
        $(event.target)
          .parents()
          .hasClass("theme-colors") ||
        $(event.target)
          .parents()
          .hasClass("theme-button") ||
        $(event.target).hasClass("theme-button") ||
        $(event.target).hasClass("theme-colors")
      )
    ) {
      if ($(".theme-colors").hasClass("shown")) {
        $(".theme-colors").removeClass("shown");
      }
    }
  });

  var Quill = require('quill');
  var QuillConfig = {
    modules: {
      toolbar: [
        ["bold", "italic", "underline", "strike"],
        ["blockquote", "code-block"],
        [{
          header: 1
        }, {
          header: 2
        }],
        [{
          list: "ordered"
        }, {
          list: "bullet"
        }],
        [{
          script: "sub"
        }, {
          script: "super"
        }],
        [{
          indent: "-1"
        }, {
          indent: "+1"
        }],
        [{
          direction: 'rtl'
        }],
        [{
          size: ["small", !1, "large", "huge"]
        }],
        [{
          header: [1, 2, 3, 4, 5, 6, !1]
        }],
        [{
          color: []
        }, {
          background: []
        }],
        [{
          font: []
        }],
        [{
          align: []
        }],
        ["clean"]
      ]
    },
    theme: "snow"
  };

  new Quill("#descQuill", QuillConfig);
  new Quill("#effectsQuill", QuillConfig);
  new Quill("#aftercareQuill", QuillConfig);

})(jQuery);
