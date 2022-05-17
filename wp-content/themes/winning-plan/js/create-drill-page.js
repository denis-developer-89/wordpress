jQuery(document).ready(function ($) {
  editPost();
  accordions();

  const singleton = Symbol("singleton");

  function editPost() {
    $(document).on("click", ".create-drill-page .accordion .edit button", function (event) {
      event.preventDefault();
      var step = $(this).attr("data-step");
      $(".create-drill-page").attr("data-step", step);
      var that = $(this);

      var data = {
        security: winning_plan_ajax_object.nonce,
        action: "edit_post",
        user_id: winning_plan_ajax_object.current_user_id,
        post_id: $(".create-drill-page").attr("data-post-id"),
        step: step,
      };

      $.ajax({
        url: winning_plan_ajax_object.ajaxurl,
        type: "POST",
        data: data,
        beforeSend: function () {
          that.closest(".accordion").find(".edit").hide();
          that.closest(".accordion").find(".create").show();
          that.closest(".accordion").addClass("active");
        },
        success: function () {},
      });
    });
  }

  function accordions(status = "") {
    var currentStep = $(".create-drill-page").attr("data-step");
    $(".create-drill-page .accordion").removeClass("active");

    $(".create-drill-page .accordion").each(function (index, element) {
      var currentIndex = index + 1;

      if (currentStep == 0 && currentIndex == 1) {
        $(element).find(".create").show();
        $(element).css("opacity", "1");
        $(element).addClass("active");
      } else if (currentIndex == currentStep) {
        $(element).addClass("active");
        $(element).css("opacity", "1");

        if (status == "create") {
          $(element).find(".edit").hide();
          $(element).find(".create").show();
        } else {
          $(element).find(".edit").show();
          if (currentStep != 2 && currentStep != 4) {
            $(element).find(".create").hide();
          }
        }
      } else if (currentIndex <= currentStep) {
        if ($(element).find(".edit").length != 0) {
          $(element).find(".edit").show();
          $(element).find(".create").hide();
        }

        if (currentStep >= 4) {
          $(".create-drill-page .form .save button").prop("disabled", false);
        }

        $(element)
          .find(".header")
          .off("click")
          .click(function (event) {
            event.preventDefault();
            console.log(currentIndex <= currentStep);
            console.log("КЛИИИК");
            console.log(element);
            if ($(this).closest(".accordion").find(".create").length && $(element).closest(".accordion").find(".create").css("display") == "block") {
              if ($(this).closest(".accordion").hasClass("active")) {
                $(this).closest(".accordion").removeClass("active");
              } else {
                $(this).closest(".accordion").addClass("active");
              }
            }
          });
      } else {
        $(element).css("opacity", "0.5");
        $(element).find(".edit").hide();
        $(element).find(".create").show();
      }
    });
  }

  // class Form {
  //   constructor() {
  //     this.accordions();
  //     this.editPost();
  //   }

  //   static getInstance() {
  //     if (!this[singleton]) {
  //       this[singleton] = new this();
  //     }

  //     return this[singleton];
  //   }

  //   editPost() {
  //     var that = this;

  //     $(document).on("click", ".create-drill-page .accordion .edit button", function (event) {
  //       event.preventDefault();
  //       var step = $(this).attr("data-step");
  //       $(".create-drill-page").attr("data-step", step);

  //       var data = {
  //         security: winning_plan_ajax_object.nonce,
  //         action: "edit_post",
  //         user_id: winning_plan_ajax_object.current_user_id,
  //         post_id: $(".create-drill-page").attr("data-post-id"),
  //         step: step,
  //       };

  //       $.ajax({
  //         url: winning_plan_ajax_object.ajaxurl,
  //         type: "POST",
  //         data: data,
  //         beforeSend: function () {
  //           $(".create-drill-page .accordion").find(".edit").hide();
  //           $(".create-drill-page .accordion").find(".create").show();
  //           $(".create-drill-page .accordion").addClass("active");

  //           // that.accordions();
  //         },
  //         success: function () {
  //           // that.accordions();
  //         },
  //       });
  //     });
  //   }
  //   accordions() {
  //     var currentStep = $(".create-drill-page").attr("data-step");
  //     $(".create-drill-page .accordion").removeClass("active");
  //     $(".create-drill-page .accordion").css("opacity", "1");
  //     console.log("accordions");
  //     console.log(currentStep);

  //     $(".create-drill-page .accordion").each(function (index, element) {
  //       var currentIndex = index + 1;

  //       if (currentStep === 0 && currentIndex == 1) {
  //         $(element).find(".create").show();
  //         $(element).first().css("opacity", "1");
  //         $(element).addClass("active");
  //       }
  //       if (currentIndex == currentStep) {
  //         $(element).addClass("active");
  //       }

  //       if (currentIndex <= currentStep) {
  //         if ($(element).find(".edit").length != 0) {
  //           $(element).find(".edit").show();
  //           $(element).find(".create").hide();
  //         }

  //         $(element)
  //           .find(".header")
  //           .click(function (event) {
  //             event.preventDefault();
  //             if ($(element).closest(".accordion").find(".create").length != 0 && $(element).closest(".accordion").find(".create").is(":visible")) {
  //               if ($(element).closest(".accordion").hasClass("active")) {
  //                 $(element).closest(".accordion").removeClass("active");
  //               } else {
  //                 $(element).closest(".accordion").addClass("active");
  //               }
  //             }
  //           });
  //       } else {
  //         $(element).css("opacity", "0.5");
  //         $(element).find(".edit").hide();
  //         $(element).find(".create").show();
  //       }
  //     });
  //   }
  // }
  // Form.getInstance();

  class FirstStep {
    constructor() {
      this.submit();
      this.changeType();
    }

    static getInstance() {
      if (!this[singleton]) {
        this[singleton] = new this();
      }

      return this[singleton];
    }

    changeType() {
      $(".create-drill-page .first-step .types .radio input").change(function () {
        var type = $(this).val();
        var data = {
          security: winning_plan_ajax_object.nonce,
          action: "first_step_filter_type",
          type: type,
          user_id: winning_plan_ajax_object.current_user_id,
          post_id: $(".create-drill-page").attr("data-post-id"),
          step: $(this).find("button[type='submit']").attr("data-step"),
        };

        $.ajax({
          url: winning_plan_ajax_object.ajaxurl,
          type: "POST",
          data: data,
          beforeSend: function () {},
          success: function (response) {
            $(".goals .checkbox-group").html(response);
          },
        });
      });
    }

    submit() {
      var that = this;
      $(document).on("submit", "#form-first-step", function (event) {
        event.preventDefault();
        var form = $(this).serialize();
        var step = parseInt($(this).find("button[type='submit']").attr("data-step")) + 1;

        var data = {
          security: winning_plan_ajax_object.nonce,
          action: "first_step_submit",
          form: form,
          user_id: winning_plan_ajax_object.current_user_id,
          post_id: $(".create-drill-page").attr("data-post-id"),
          step: step,
        };

        $.ajax({
          url: winning_plan_ajax_object.ajaxurl,
          type: "POST",
          data: data,
          beforeSend: function () {
            $(".create-drill-page .first-step .accordion").css("position", "relative");
            $(".create-drill-page .first-step .accordion").append('<div class="loader"></div>');
            $(".create-drill-page .first-step button[type='submit']").prop("disabled", true);
          },
          success: function (response) {
            var post_id = $.parseJSON(response);
            $(".create-drill-page").attr("data-step", step);
            $(".create-drill-page").attr("data-post-id", post_id);
            window.history.replaceState(null, null, `?edit_id=${post_id}`);

            var data = {
              security: winning_plan_ajax_object.nonce,
              action: "second_step_filter_categories_first_step_view",
              post_id: post_id,
            };

            $.ajax({
              url: winning_plan_ajax_object.ajaxurl,
              type: "post",
              dataType: "json",
              data: data,
              success: function (response) {
                $(".create-drill-page .first-step .accordion").removeAttr("style");
                $(".create-drill-page .first-step .accordion .loader").remove();
                $(".create-drill-page .first-step .edit").replaceWith(response.first_step_view);
                $(".create-drill-page .second-step .categories").html(response.categories);
                $(".create-drill-page .first-step button[type='submit']").prop("disabled", false);
                accordions();
              },
            });
          },
        });
      });
    }
  }
  FirstStep.getInstance();

  class SecondStep {
    constructor() {
      this.submit();
      this.categoryAccordions();
    }

    static getInstance() {
      if (!this[singleton]) {
        this[singleton] = new this();
      }

      return this[singleton];
    }

    submit() {
      var that = this;
      $("#form-second-step").submit(function (event) {
        event.preventDefault();

        var form = $(this).serialize();
        var step = parseInt($(this).find("button[type='submit']").attr("data-step")) + 1;

        var data = {
          security: winning_plan_ajax_object.nonce,
          action: "second_step_submit",
          user_id: winning_plan_ajax_object.current_user_id,
          form: form,
          post_id: $(".create-drill-page").attr("data-post-id"),
          step: step,
        };

        $.ajax({
          url: winning_plan_ajax_object.ajaxurl,
          type: "POST",
          data: data,
          beforeSend: function () {
            $(".create-drill-page .second-step .accordion").css("position", "relative");
            $(".create-drill-page .second-step .accordion").append('<div class="loader"></div>');
            $(".create-drill-page .second-step button[type='submit']").prop("disabled", true);
          },
          success: function (response) {
            $(".create-drill-page .second-step .accordion").removeAttr("style");
            $(".create-drill-page .second-step .accordion .loader").remove();
            $(".create-drill-page").attr("data-step", step);
            $(".create-drill-page .second-step button[type='submit']").prop("disabled", false);
            accordions("create");
          },
        });
      });
    }

    categoryAccordions() {
      $(document).on("click", ".create-drill-page .category .category-header .arrow", function (event) {
        event.preventDefault();
        if ($(this).closest(".category").hasClass("active")) {
          $(this).closest(".category").removeClass("active");
        } else {
          $(this).closest(".category").toggleClass("active");
        }
      });

      $(document).on("click", ".category-header input", function (event) {
        if ($(this).prop("checked")) {
          $(this).closest(".category").find("input").prop("checked", true);
        } else {
          $(this).closest(".category").find("input").prop("checked", false);
        }
      });

      $(document).on("click", ".sub-category-header input", function (event) {
        if ($(this).prop("checked")) {
          $(this).closest(".sub-category").find(".sub-category-content input").prop("checked", true);
        } else {
          $(this).closest(".sub-category").find(".sub-category-content input").prop("checked", false);
        }
      });
    }
  }
  SecondStep.getInstance();

  class ThirdStep {
    constructor() {
      this.canvas;
      this.flipX = false;
      this.historyCanvas();
      this.initCanvas();
      this.navCanvas();
      this.dragAndDrop();
      this.tabs();
      this.switcherTabs();
      this.exchangesTab();
      this.playersTab();
      this.markingsTab();
      this.thingsTab();
      this.arrowsTab();
      this.fileUpload();
      this.submitImage();
      this.submitCanvas();
    }

    submitImage() {
      var that = this;
      $("#form-third-step-upload").submit(function (event) {
        event.preventDefault();
        var step = parseInt($(this).find("button[type='submit']").attr("data-step")) + 1;

        var formData = new FormData();
        var files = $(this).find(".file-upload input")[0].files[0];

        formData.append("security", winning_plan_ajax_object.nonce);
        formData.append("action", "third_step_submit");
        formData.append("user_id", winning_plan_ajax_object.current_user_id);
        formData.append("file", files);
        formData.append("post_id", $(".create-drill-page").data("post-id"));
        formData.append("step", $(this).find("button[type='submit']").data("step") + 1);

        $.ajax({
          url: winning_plan_ajax_object.ajaxurl,
          type: "POST",
          processData: false,
          contentType: false,
          data: formData,

          beforeSend: function () {
            $(".create-drill-page .third-step .accordion").css("position", "relative");
            $(".create-drill-page .third-step .accordion").append('<div class="loader"></div>');
            $(".create-drill-page .third-step button[type='submit']").prop("disabled", true);
          },
          success: function (response) {
            $(".create-drill-page .third-step .accordion").removeAttr("style");
            $(".create-drill-page .third-step .accordion .loader").remove();
            $(".create-drill-page .third-step .edit .thumbnail").html(response);
            $(".create-drill-page").attr("data-step", step);
            $(".create-drill-page .third-step button[type='submit']").prop("disabled", false);
            accordions();
          },
        });
      });
    }
    submitCanvas() {}

    static getInstance() {
      if (!this[singleton]) {
        this[singleton] = new this();
      }

      return this[singleton];
    }

    fileUpload() {
      $(".file-upload button").click(function () {
        $(this).closest(".file-upload").find("input").click();
      });

      $(".upload .clear").click(function (event) {
        event.preventDefault();
        $(this).closest(".upload").find(".file-name").text("בחירת קובץ");
        $(".upload .upload-image-preview img").remove();
      });

      $(".file-upload input").change(function () {
        if ($(this)[0].files.length != 0) {
          const fileName = $(this)[0].files[0].name;
          const file = $(this)[0].files[0];
          $(this).closest(".upload").find(".file-name").text(fileName);
          if (file) {
            var reader = new FileReader();
            reader.onload = function (event) {
              $(".upload .upload-image-preview img").remove();
              $(".upload .upload-image-preview").append(`<img src="${event.target.result}"/>`);
            };
            reader.readAsDataURL(file);
          }
        } else {
          $(this).closest(".upload").find(".file-name").text("בחירת קובץ");
        }
      });
    }

    switcherTabs() {
      $(".third-step .switcher .switcher-tab").click(function () {
        $(".third-step .switcher .switcher-tab").removeClass("active").eq($(this).index()).addClass("active");
        $(".third-step .switchers-content .switcher-content").removeClass("active").hide().eq($(this).index()).show().addClass("active");
      });
    }

    tabs() {
      $(".third-step .tabs .tab").click(function () {
        $(".third-step .tabs .tab").removeClass("active").eq($(this).index()).addClass("active");
        $(".third-step .tabs-content .tab-content").removeClass("active").hide().eq($(this).index()).show().addClass("active");
      });
    }

    historyCanvas() {
      var that = this;

      /**
       * Override the initialize function for the _historyInit();
       */
      fabric.Canvas.prototype.initialize = (function (originalFn) {
        return function (...args) {
          originalFn.call(this, ...args);
          this._historyInit();
          return this;
        };
      })(fabric.Canvas.prototype.initialize);

      /**
       * Override the dispose function for the _historyDispose();
       */
      fabric.Canvas.prototype.dispose = (function (originalFn) {
        return function (...args) {
          originalFn.call(this, ...args);
          this._historyDispose();
          return this;
        };
      })(fabric.Canvas.prototype.dispose);

      /**
       * Returns current state of the string of the canvas
       */
      fabric.Canvas.prototype._historyNext = function () {
        return JSON.stringify(this.toDatalessJSON(this.extraProps));
      };

      /**
       * Returns an object with fabricjs event mappings
       */
      fabric.Canvas.prototype._historyEvents = function () {
        return {
          "object:added": this._historySaveAction,
          "object:removed": this._historySaveAction,
          "object:modified": this._historySaveAction,
          "object:skewing": this._historySaveAction,
        };
      };

      /**
       * Initialization of the plugin
       */
      fabric.Canvas.prototype._historyInit = function () {
        this.historyUndo = [];
        this.historyRedo = [];
        this.extraProps = ["selectable"];
        this.historyNextState = this._historyNext();

        this.on(this._historyEvents());
      };

      /**
       * Remove the custom event listeners
       */
      fabric.Canvas.prototype._historyDispose = function () {
        this.off(this._historyEvents());
      };

      /**
       * It pushes the state of the canvas into history stack
       */
      fabric.Canvas.prototype._historySaveAction = function () {
        if (this.historyProcessing) return;

        const json = this.historyNextState;
        this.historyUndo.push(json);
        this.historyNextState = this._historyNext();
        this.fire("history:append", { json: json });
      };

      /**
       * Undo to latest history.
       * Pop the latest state of the history. Re-render.
       * Also, pushes into redo history.
       */
      fabric.Canvas.prototype.undo = function (callback) {
        // The undo process will render the new states of the objects
        // Therefore, object:added and object:modified events will triggered again
        // To ignore those events, we are setting a flag.
        this.historyProcessing = true;

        const history = this.historyUndo.pop();

        if (history && this.historyUndo.length >= 0) {
          // Push the current state to the redo history
          this.historyRedo.push(this._historyNext());
          this.historyNextState = history;
          this._loadHistory(history, "history:undo", callback);
        } else {
          const imageUrl = $(".exchanges .slider .swiper .swiper-slide .fild.active").attr("src");

          fabric.Image.fromURL(imageUrl, function (img) {
            that.canvas.setBackgroundImage(img, that.canvas.renderAll.bind(that.canvas), {
              scaleX: canvas.width / img.width,
              scaleY: canvas.height / img.height,
            });
          });

          this.historyProcessing = false;
        }
      };

      /**
       * Redo to latest undo history.
       */
      fabric.Canvas.prototype.redo = function (callback) {
        // The undo process will render the new states of the objects
        // Therefore, object:added and object:modified events will triggered again
        // To ignore those events, we are setting a flag.
        this.historyProcessing = true;
        const history = this.historyRedo.pop();
        if (history) {
          // Every redo action is actually a new action to the undo history
          this.historyUndo.push(this._historyNext());
          this.historyNextState = history;
          this._loadHistory(history, "history:redo", callback);
        } else {
          this.historyProcessing = false;
        }
      };

      fabric.Canvas.prototype._loadHistory = function (history, event, callback) {
        var that = this;

        this.loadFromJSON(history, function () {
          that.renderAll();
          that.fire(event);
          that.historyProcessing = false;

          if (callback && typeof callback === "function") callback();
        });
      };

      /**
       * Clear undo and redo history stacks
       */
      fabric.Canvas.prototype.clearHistory = function () {
        this.historyUndo = [];
        this.historyRedo = [];
        this.fire("history:clear");
      };

      /**
       * Off the history
       */
      fabric.Canvas.prototype.offHistory = function () {
        this.historyProcessing = true;
      };

      /**
       * On the history
       */
      fabric.Canvas.prototype.onHistory = function () {
        this.historyProcessing = false;

        this._historySaveAction();
      };
    }

    initCanvas = () => {
      const that = this;
      this.canvas = new fabric.Canvas("canvas", {
        width: 800,
        height: 472,
        hoverCursor: "pointer",
        // backgroundColor: "yellow"
      });

      const imageUrl = $(".third-step .slider .fild img").first().attr("src");

      fabric.Image.fromURL(imageUrl, function (img) {
        that.canvas.setBackgroundImage(img, that.canvas.renderAll.bind(that.canvas), {
          scaleX: canvas.width / img.width,
          scaleY: canvas.height / img.height,
        });
      });

      // $(".canvas .canvas-container").css('background', 'url(' + imageUrl + ')');
    };

    navCanvas() {
      const that = this;
      $(".nav .history .undo").click(function (event) {
        that.canvas.undo();
      });

      $(".nav .history .redo").click(function (event) {
        that.canvas.redo();
      });

      $(".nav .clear a").click(function (event) {
        event.preventDefault();
        that.canvas.remove(...that.canvas.getObjects());
        // canvas.clear()
      });
    }

    exchangesTab() {
      const that = this;

      const swiper = new Swiper(".third-step .slider .swiper", {
        slidesPerView: 5,
        spaceBetween: 20,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });

      $(document).on("click", ".third-step .slider .fild img", function (event) {
        $(".third-step .slider .fild").removeClass("active");
        $(this).parent().addClass("active");

        const imageUrl = $(this).attr("src");

        fabric.Image.fromURL(imageUrl, function (img) {
          that.canvas.setBackgroundImage(img, that.canvas.renderAll.bind(that.canvas), {
            scaleX: canvas.width / img.width,
            scaleY: canvas.height / img.height,
          });
        });

        // $(".canvas .canvas-container").css('background', 'url(' + imageUrl + ')');
      });
    }

    playersTab() {
      const that = this;

      $(".third-step .tabs-content .football-players .options .current-color").click(function (event) {
        $(this).closest(".options").find(".choose-color").show();
      });

      $(".third-step .tabs-content .football-players .options .color .choose-color .radio label").click(function (event) {
        var currentColor;
        var prevColor;

        prevColor = $(".third-step .tabs-content .football-players .choose-color .radio.active input").val();

        if (prevColor != null && prevColor != undefined) {
          prevColor = prevColor.toLowerCase();
        }

        $(".third-step .tabs-content .football-players .options .color .choose-color .radio").removeClass("active");
        $(this).parent().addClass("active");

        currentColor = $(this).parent().find("input").val();

        if (currentColor != null && currentColor != undefined) {
          currentColor = currentColor.toLowerCase();
        }

        $(".third-step .tabs-content .football-players svg").each(function (index, element) {
          $(element)
            .find("path")
            .each(function (index, svgElement) {
              var fill = $(svgElement).attr("fill");
              var stroke = $(svgElement).attr("stroke");

              if (fill != null && fill != undefined) {
                fill = fill.toLowerCase();
              }
              if (stroke != null && stroke != undefined) {
                stroke = stroke.toLowerCase();
              }

              if (fill != null && fill != undefined && fill == prevColor) {
                $(svgElement).attr("fill", currentColor);
              }
              if (stroke != null && stroke != undefined && stroke == prevColor) {
                $(svgElement).attr("stroke", currentColor);
              }
            });

          $(element)
            .find("line")
            .each(function (index, svgElement) {
              var fill = $(svgElement).attr("fill");
              var stroke = $(svgElement).attr("stroke");

              if (fill != null && fill != undefined) {
                fill = fill.toLowerCase();
              }
              if (stroke != null && stroke != undefined) {
                stroke = stroke.toLowerCase();
              }

              if (fill != null && fill != undefined && fill == prevColor) {
                $(svgElement).attr("fill", currentColor);
              }
              if (stroke != null && stroke != undefined && stroke == prevColor) {
                $(svgElement).attr("stroke", currentColor);
              }
            });

          $(element)
            .find("rect")
            .each(function (index, svgElement) {
              var fill = $(svgElement).attr("fill");
              var stroke = $(svgElement).attr("stroke");

              if (fill != null && fill != undefined) {
                fill = fill.toLowerCase();
              }
              if (stroke != null && stroke != undefined) {
                stroke = stroke.toLowerCase();
              }

              if (fill != null && fill != undefined && fill == prevColor) {
                $(svgElement).attr("fill", currentColor);
              }
              if (stroke != null && stroke != undefined && stroke == prevColor) {
                $(svgElement).attr("stroke", currentColor);
              }
            });

          $(element)
            .find("linearGradient")
            .each(function (index, svgElement) {
              var stopColor = $(svgElement).attr("stop-color");

              if (stopColor != null && stopColor != undefined) {
                stopColor = stopColor.toLowerCase();
              }

              if (stopColor != null && stopColor != undefined && stopColor == prevColor) {
                $(svgElement).attr("stop-color", currentColor);
              }
            });
        });

        $(this).closest(".options").find(".current-color").css("backgroundColor", currentColor);
        $(this).closest(".options").find(".choose-color").hide();
      });

      $(".third-step .tabs-content .football-players .options .trun-over").click(function (event) {
        if ($(this).hasClass("active")) {
          $(this).removeClass("active");
          that.flipX = false;
          $(".third-step .player svg").each(function (index, element) {
            $(element).parent().removeAttr("style");
            $(element).removeAttr("style");
            $(element).removeAttr("transform");
          });
        } else {
          $(this).addClass("active");
          that.flipX = true;
          $(".third-step .football-players svg").each(function (index, element) {
            $(element).attr("transform", `scale(-1,1)`);
          });
        }
      });
    }

    markingsTab() {
      const that = this;

      $(".third-step .tabs-content .markings .options .current-color").click(function (event) {
        $(this).closest(".options").find(".choose-color").show();
      });

      $(".third-step .tabs-content .markings .options .color .choose-color .radio label").click(function (event) {
        var currentColor;
        var prevColor;

        prevColor = $(".third-step .tabs-content .markings .choose-color .radio.active input").val();

        if (prevColor != null && prevColor != undefined) {
          prevColor = prevColor.toLowerCase();
        }

        $(".third-step .tabs-content .markings .options .color .choose-color .radio").removeClass("active");
        $(this).parent().addClass("active");

        currentColor = $(this).parent().find("input").val();

        if (currentColor != null && currentColor != undefined) {
          currentColor = currentColor.toLowerCase();
        }

        $(".third-step .tabs-content .markings svg").each(function (index, element) {
          $(element)
            .find("path")
            .each(function (index, svgElement) {
              var fill = $(svgElement).attr("fill");
              var stroke = $(svgElement).attr("stroke");

              if (fill != null && fill != undefined) {
                fill = fill.toLowerCase();
              }
              if (stroke != null && stroke != undefined) {
                stroke = stroke.toLowerCase();
              }

              if (fill != null && fill != undefined && fill == prevColor) {
                $(svgElement).attr("fill", currentColor);
              }
              if (stroke != null && stroke != undefined && stroke == prevColor) {
                $(svgElement).attr("stroke", currentColor);
              }
            });

          $(element)
            .find("line")
            .each(function (index, svgElement) {
              var fill = $(svgElement).attr("fill");
              var stroke = $(svgElement).attr("stroke");

              if (fill != null && fill != undefined) {
                fill = fill.toLowerCase();
              }
              if (stroke != null && stroke != undefined) {
                stroke = stroke.toLowerCase();
              }

              if (fill != null && fill != undefined && fill == prevColor) {
                $(svgElement).attr("fill", currentColor);
              }
              if (stroke != null && stroke != undefined && stroke == prevColor) {
                $(svgElement).attr("stroke", currentColor);
              }
            });

          $(element)
            .find("rect")
            .each(function (index, svgElement) {
              var fill = $(svgElement).attr("fill");
              var stroke = $(svgElement).attr("stroke");

              if (fill != null && fill != undefined) {
                fill = fill.toLowerCase();
              }
              if (stroke != null && stroke != undefined) {
                stroke = stroke.toLowerCase();
              }

              if (fill != null && fill != undefined && fill == prevColor) {
                $(svgElement).attr("fill", currentColor);
              }
              if (stroke != null && stroke != undefined && stroke == prevColor) {
                $(svgElement).attr("stroke", currentColor);
              }
            });

          $(element)
            .find("linearGradient")
            .each(function (index, svgElement) {
              var stopColor = $(svgElement).attr("stop-color");

              if (stopColor != null && stopColor != undefined) {
                stopColor = stopColor.toLowerCase();
              }

              if (stopColor != null && stopColor != undefined && stopColor == prevColor) {
                $(svgElement).attr("stop-color", currentColor);
              }
            });
        });

        $(this).closest(".options").find(".current-color").css("backgroundColor", currentColor);
        $(this).closest(".options").find(".choose-color").hide();
      });

      $(".third-step .tabs-content .markings .options .trun-over").click(function (event) {
        if ($(this).hasClass("active")) {
          $(this).removeClass("active");
          that.flipX = false;
          $(".third-step .tabs-content .markings svg").each(function (index, element) {
            $(element).parent().removeAttr("style");
            $(element).removeAttr("style");
            $(element).removeAttr("transform");
          });
        } else {
          $(this).addClass("active");
          that.flipX = true;
          $(".third-step .tabs-content svg").each(function (index, element) {
            $(element).attr("transform", `scale(-1,1)`);
          });
        }
      });
    }

    thingsTab() {
      const that = this;

      $(".third-step .tabs-content .things .options .current-color").click(function (event) {
        $(this).closest(".options").find(".choose-color").show();
      });

      $(".third-step .tabs-content .things .options .color .choose-color .radio label").click(function (event) {
        var currentColor;
        var prevColor;

        prevColor = $(".third-step .tabs-content .things .choose-color .radio.active input").val();

        if (prevColor != null && prevColor != undefined) {
          prevColor = prevColor.toLowerCase();
        }

        $(".third-step .tabs-content .things .options .color .choose-color .radio").removeClass("active");
        $(this).parent().addClass("active");

        currentColor = $(this).parent().find("input").val();

        if (currentColor != null && currentColor != undefined) {
          currentColor = currentColor.toLowerCase();
        }

        $(".third-step .tabs-content .things svg").each(function (index, element) {
          $(element)
            .find("path")
            .each(function (index, svgElement) {
              var fill = $(svgElement).attr("fill");
              var stroke = $(svgElement).attr("stroke");

              if (fill != null && fill != undefined) {
                fill = fill.toLowerCase();
              }
              if (stroke != null && stroke != undefined) {
                stroke = stroke.toLowerCase();
              }

              if (fill != null && fill != undefined && fill == prevColor) {
                $(svgElement).attr("fill", currentColor);
              }
              if (stroke != null && stroke != undefined && stroke == prevColor) {
                $(svgElement).attr("stroke", currentColor);
              }
            });

          $(element)
            .find("line")
            .each(function (index, svgElement) {
              var fill = $(svgElement).attr("fill");
              var stroke = $(svgElement).attr("stroke");

              if (fill != null && fill != undefined) {
                fill = fill.toLowerCase();
              }
              if (stroke != null && stroke != undefined) {
                stroke = stroke.toLowerCase();
              }

              if (fill != null && fill != undefined && fill == prevColor) {
                $(svgElement).attr("fill", currentColor);
              }
              if (stroke != null && stroke != undefined && stroke == prevColor) {
                $(svgElement).attr("stroke", currentColor);
              }
            });

          $(element)
            .find("rect")
            .each(function (index, svgElement) {
              var fill = $(svgElement).attr("fill");
              var stroke = $(svgElement).attr("stroke");

              if (fill != null && fill != undefined) {
                fill = fill.toLowerCase();
              }
              if (stroke != null && stroke != undefined) {
                stroke = stroke.toLowerCase();
              }

              if (fill != null && fill != undefined && fill == prevColor) {
                $(svgElement).attr("fill", currentColor);
              }
              if (stroke != null && stroke != undefined && stroke == prevColor) {
                $(svgElement).attr("stroke", currentColor);
              }
            });

          $(element)
            .find("linearGradient")
            .each(function (index, svgElement) {
              var stopColor = $(svgElement).attr("stop-color");

              if (stopColor != null && stopColor != undefined) {
                stopColor = stopColor.toLowerCase();
              }

              if (stopColor != null && stopColor != undefined && stopColor == prevColor) {
                $(svgElement).attr("stop-color", currentColor);
              }
            });
        });

        $(this).closest(".options").find(".current-color").css("backgroundColor", currentColor);
        $(this).closest(".options").find(".choose-color").hide();
      });

      $(".third-step .tabs-content .things .options .trun-over").click(function (event) {
        if ($(this).hasClass("active")) {
          $(this).removeClass("active");
          that.flipX = false;
          $(".third-step .things svg").each(function (index, element) {
            $(element).parent().removeAttr("style");
            $(element).removeAttr("style");
            $(element).removeAttr("transform");
          });
        } else {
          $(this).addClass("active");
          that.flipX = true;
          $(".third-step .things svg").each(function (index, element) {
            $(element).attr("transform", `scale(-1,1)`);
          });
        }
      });
    }

    arrowsTab() {
      const that = this;

      $(".third-step .tabs-content .arrows .options .current-color").click(function (event) {
        $(this).closest(".options").find(".choose-color").show();
      });

      $(".third-step .tabs-content .arrows .options .color .choose-color .radio label").click(function (event) {
        var currentColor;
        var prevColor;

        prevColor = $(".third-step .tabs-content .arrows .choose-color .radio.active input").val();

        if (prevColor != null && prevColor != undefined) {
          prevColor = prevColor.toLowerCase();
        }

        $(".third-step .tabs-content .arrows .options .color .choose-color .radio").removeClass("active");
        $(this).parent().addClass("active");

        currentColor = $(this).parent().find("input").val();

        if (currentColor != null && currentColor != undefined) {
          currentColor = currentColor.toLowerCase();
        }

        $(".third-step .tabs-content .arrows svg").each(function (index, element) {
          $(element)
            .find("path")
            .each(function (index, svgElement) {
              var fill = $(svgElement).attr("fill");
              var stroke = $(svgElement).attr("stroke");

              if (fill != null && fill != undefined) {
                fill = fill.toLowerCase();
              }
              if (stroke != null && stroke != undefined) {
                stroke = stroke.toLowerCase();
              }

              if (fill != null && fill != undefined && fill == prevColor) {
                $(svgElement).attr("fill", currentColor);
              }
              if (stroke != null && stroke != undefined && stroke == prevColor) {
                $(svgElement).attr("stroke", currentColor);
              }
            });

          $(element)
            .find("line")
            .each(function (index, svgElement) {
              var fill = $(svgElement).attr("fill");
              var stroke = $(svgElement).attr("stroke");

              if (fill != null && fill != undefined) {
                fill = fill.toLowerCase();
              }
              if (stroke != null && stroke != undefined) {
                stroke = stroke.toLowerCase();
              }

              if (fill != null && fill != undefined && fill == prevColor) {
                $(svgElement).attr("fill", currentColor);
              }
              if (stroke != null && stroke != undefined && stroke == prevColor) {
                $(svgElement).attr("stroke", currentColor);
              }
            });

          $(element)
            .find("rect")
            .each(function (index, svgElement) {
              var fill = $(svgElement).attr("fill");
              var stroke = $(svgElement).attr("stroke");

              if (fill != null && fill != undefined) {
                fill = fill.toLowerCase();
              }
              if (stroke != null && stroke != undefined) {
                stroke = stroke.toLowerCase();
              }

              if (fill != null && fill != undefined && fill == prevColor) {
                $(svgElement).attr("fill", currentColor);
              }
              if (stroke != null && stroke != undefined && stroke == prevColor) {
                $(svgElement).attr("stroke", currentColor);
              }
            });

          $(element)
            .find("linearGradient")
            .each(function (index, svgElement) {
              var stopColor = $(svgElement).attr("stop-color");

              if (stopColor != null && stopColor != undefined) {
                stopColor = stopColor.toLowerCase();
              }

              if (stopColor != null && stopColor != undefined && stopColor == prevColor) {
                $(svgElement).attr("stop-color", currentColor);
              }
            });
        });

        $(this).closest(".options").find(".current-color").css("backgroundColor", currentColor);
        $(this).closest(".options").find(".choose-color").hide();
      });

      $(".third-step .tabs-content .arrows .options .trun-over").click(function (event) {
        if ($(this).hasClass("active")) {
          $(this).removeClass("active");
          that.flipX = false;
          $(".third-step .arrows svg").each(function (index, element) {
            $(element).parent().removeAttr("style");
            $(element).removeAttr("style");
            $(element).removeAttr("transform");
          });
        } else {
          $(this).addClass("active");
          that.flipX = true;
          $(".third-step .arrows svg").each(function (index, element) {
            $(element).attr("transform", `scale(-1,1)`);
          });
        }
      });
    }

    dragAndDrop() {
      const that = this;
      var scaleX = 1;
      var scaleY = 1;

      $(".third-step .football-players .player svg").draggable({
        revert: "invalid",
        helper: "clone",
        zIndex: 9999,
        cursor: "pointer",
      });

      $(".third-step .markings .marks svg").draggable({
        revert: "invalid",
        helper: "clone",
        zIndex: 9999,
        cursor: "pointer",
      });

      $(".third-step .things .thing svg").draggable({
        revert: "invalid",
        helper: "clone",
        zIndex: 9999,
        cursor: "pointer",
      });
      $(".third-step .arrows .arrow svg").draggable({
        revert: "invalid",
        helper: "clone",
        zIndex: 9999,
        cursor: "pointer",
      });

      $(".third-step .canvas .canvas-container").droppable({
        drop: function (event, ui) {
          var topOffset = ui.offset.top - $(this).offset().top;
          var leftOffset = ui.offset.left - $(this).offset().left;

          if (!$(ui.draggable).parents().hasClass("text")) {
            var svgElement = ui.draggable[0];
            var serializer = new XMLSerializer();
            var svgString = serializer.serializeToString(svgElement);
            var newSvgString = svgString.replace('transform="scale(-1,1)"', "");
            var path = fabric.loadSVGFromString(newSvgString, function (objects, options) {
              var obj = fabric.util.groupSVGElements(objects, options);
              obj.set({
                top: topOffset,
                left: leftOffset,
                scaleX: scaleX,
                scaleY: scaleY,
                minScaleLimit: 1,
                flipX: that.flipX,
                lockScalingFlip: true,
              });

              // obj.setControlsVisibility({
              //     mt: false, // middle top disable
              //     mb: false, // midle bottom
              //     ml: false, // middle left
              //     mr: false, // I think you get it
              // });

              that.canvas.add(obj);
            });
          } else {
            var text = new fabric.IText("T", {
              top: topOffset,
              left: leftOffset,
              minScaleLimit: 0.5,
              fontSize: 30,
            });
            that.canvas.add(text);
          }
        },
      });

      // this.canvas.on("object:scaling", function(event) {
      //     var maxScaleX = 3;
      //     var maxScaleY = 3;

      //     // var lastGoodLeft;
      //     // var lastGoodTop;

      //     // if (event.target.scaleX < maxScaleX) {
      //     //     // event.target.scaleX = maxScaleX;
      //     //    event.target.left = lastGoodLeft;
      //     //     event.target.top = lastGoodTop;
      //     // }
      //     // if (event.target.scaleY <  maxScaleY) {
      //     //     // event.target.scaleY = maxScaleY;
      //     //     event.target.left = lastGoodLeft;
      //     //     event.target.top = lastGoodTop;
      //     // }

      //     //     console.log(lastGoodTop);
      //     //     console.log(lastGoodLeft);
      //     // lastGoodTop = event.target.top;
      //     // lastGoodLeft = event.target.left;

      //     // if () {

      //     that.canvas.getObjects().map(function(obj) {

      //         if (event.target.scaleX < maxScaleX) {
      //             scaleX = event.target.scaleX;
      //         }
      //         if (event.target.scaleY < maxScaleY) {
      //             scaleY = event.target.scaleY;
      //         }
      //         return obj.set({ 'scaleX': scaleX, 'scaleY': scaleY });
      //     })

      //     // }

      // });
    }
  }
  ThirdStep.getInstance();

  class FouthdStep {
    constructor() {
      this.dynamicInputs();
      this.submit();
    }
    static getInstance() {
      if (!this[singleton]) {
        this[singleton] = new this();
      }

      return this[singleton];
    }

    submit() {
      var that = this;
      $(".create-drill-page .form .save button").click(function (event) {
        event.preventDefault();

        var form = $("#form-fouth-step").serialize();
        var step = parseInt($(this).attr("data-step")) + 1;

        var data = {
          security: winning_plan_ajax_object.nonce,
          action: "fouth_step_submit",
          user_id: winning_plan_ajax_object.current_user_id,
          form: form,
          post_id: $(".create-drill-page").attr("data-post-id"),
          step: step,
        };

        $.ajax({
          url: winning_plan_ajax_object.ajaxurl,
          type: "POST",
          data: data,
          beforeSend: function () {
            $(".create-drill-page .fouth-step .accordion").css("position", "relative");
            $(".create-drill-page .fouth-step .accordion").append('<div class="loader"></div>');
          },
          success: function (response) {
            $(".create-drill-page .fouth-step .accordion").removeAttr("style");
            $(".create-drill-page .fouth-step .accordion .loader").remove();
            $(".create-drill-page").attr("data-step", step);
            accordions();
          },
        });
      });
    }
    dynamicInputs() {
      $(".fouth-step .dynamic-inputs .add-more button").click(function (event) {
        event.preventDefault();
        var input = $(this).closest(".dynamic-inputs").find("#template").html();
        $(this).before(input);
        $(this)
          .closest(".dynamic-inputs")
          .find(".input")
          .each(function (index, value) {
            index++;
            $(this).find("input").attr("name", "description-emphasis[]");
            $(this).find(".number").html(index);
          });
      });

      $(document).on("click", ".fouth-step .dynamic-inputs .input .delete", function (event) {
        event.preventDefault();
        $(this).parent().remove();
        $(".fouth-step .dynamic-inputs")
          .find(".input")
          .each(function (index, value) {
            index++;
            $(this).find("input").attr("name", "description-emphasis[]");
            $(this).find(".number").html(index);
          });
      });
    }
  }
  FouthdStep.getInstance();
});
