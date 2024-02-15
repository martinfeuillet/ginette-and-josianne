(function ($) {
  "use strict";
  console.log("Script loaded");

  $(function () {
    /**
     * Sets up initial event handlers for wishlist interactions.
     */
    function setEventHandler() {
      setTimeout(updateEventHandlers, 5000);
    }

    /**
     * Updates event handlers, especially after AJAX content loading.
     */
    function updateEventHandlers() {
      $(".gj-add-to-wishlist")
        .off("click")
        .on("click", add_to_wishlist_click_handler);
      $(".gj-wishlist-delete-item")
        .off("click")
        .on("click", delete_from_wishlist_click_handler);
      $(".jet-filters-pagination__link")
        .off("click")
        .on("click", setEventHandler);
    }

    /**
     * Handles the click event for adding an item to the wishlist.
     */
    function add_to_wishlist_click_handler() {
      let post_id = $(this).data("post-id");
      let button = $(this);
      let rootUrl = window.location.origin;
      button.addClass("blinking");

      $.ajax({
        url: wp_ajax.ajax_url,
        type: "POST",
        data: {
          action: "add_post_to_wishlist",
          post_id: post_id,
        },
        success: (response) => {
          if (response.success) {
            let buttonImg = button.find("img");
            buttonImg.attr(
              "src",
              rootUrl + "/wp-content/uploads/2023/12/heart-solid-1.svg"
            );
            button.attr("href", rootUrl + "/mon-compte/wishlist");
            $(this).removeClass("blinking");
          } else {
            if (response.data.redirect_url) {
              window.location.href = response.data.redirect_url;
            } else {
            }
          }
        },
      });
    }

    /**
     * Handles the click event for deleting an item from the wishlist.
     */
    function delete_from_wishlist_click_handler() {
      let post_id = $(this).data("post-id");
      let parentDiv = $(this).closest(".gj-wishlist-post-item");
      let button = $(this);
      button.addClass("blinking");

      $.ajax({
        url: wp_ajax.ajax_url,
        type: "POST",
        data: {
          action: "delete_post_from_wishlist",
          post_id: post_id,
        },
        success: (response) => {
          if (response.success) {
            let buttonImg = button.find("img");
            buttonImg.attr(
              "src",
              "/wp-content/uploads/2023/11/heart-regular.svg"
            );
            button
              .removeClass("gj-wishlist-delete-item")
              .addClass("gj-add-to-wishlist");
            button.off("click").on("click", add_to_wishlist_click_handler);
            $(this).removeClass("blinking");
          } else {
            if (response.data.redirect_url) {
              window.location.href = response.data.redirect_url;
            } else {
            }
          }
        },
      });
    }

    /**
     * Initially shows the first paragraph of the product excerpt in the wishlist.
     */
    $("div.gj-wishlist-product-excerpt").each(function () {
      let firstP = $(this).find("p:first");
      if (firstP.length > 0) {
        firstP.css("display", "block");
      }
    });

    /**
     * Handles click events on wishlist filter tabs.
     */
    $("a.gj-wishlist-tab-content-filter").on("click", function () {
      let buttonId = $(this).attr("id");
      $("a.gj-wishlist-tab-content-filter").removeClass("filter-active");
      $(this).addClass("filter-active");
      loadPosts(1);
    });

    /**
     * Function to load posts based on the current page and filter.
     * It calculates the total pages and then calls loadFilteredWishlistPosts.
     * @param {number} page - The current page number the user is on.
     */
    function loadPosts(page) {
      let currentPage = page;
      let currentFilter = $(".filter-active").attr("id");
      let maxPages = $(`#${currentFilter}-posts`).val();

      // console.log('currentPage : ' + currentPage, 'currentFilter : ' + currentFilter, 'maxPages : ' + maxPages)
      loadFilteredWishlistPosts(currentPage, currentFilter, maxPages);
    }

    /**
     * Function to load wishlist posts based on the current page, filter, and total pages.
     * It sends an AJAX request and updates the HTML content based on the response.
     * @param {number} currentPage - The current page number to be loaded.
     * @param {string} currentFilter - The active filter id to determine which set of posts to load.
     * @param {number} maxPages - The total number of pages available based on the filter.
     */
    function loadFilteredWishlistPosts(currentPage, currentFilter, maxPages) {
      $(".gj-wishlist-tab-content-first-three-posts").addClass("blinking");
      $(".gj-wishlist-tab-content-remaining-posts").addClass("blinking");
      let page = currentPage;
      let filter = currentFilter;
      let pages = Math.ceil(maxPages / 12);
      let is_member = $("#is_member_input").val();
      // console.log('page : ' + page, 'filter : ' + filter, 'pages : ' + pages)

      $.ajax({
        url: wp_ajax.ajax_url,
        type: "POST",
        data: {
          action: "load_filtered_wishlist_posts",
          page: page,
          filter: filter,
          pages: pages,
        },
        success: function (response) {
          // console.log(response)
          if (response.success) {
            let postIndex = 0;
            let firstThreePostsHtml = "";
            let remainingPostsHtml = "";
            // console.log(response.data.posts)
            response.data.posts.forEach(function (post) {
              let postsHtml = "";
              if (post.type === "product") {
                let starsHtml = "";
                for (let i = 0; i < 5; i++) {
                  starsHtml +=
                    '<img src="https://wordpress-622051-3851898.cloudwaysapps.com/wp-content/uploads/2023/12/star-regular.svg" alt="star icon"/>';
                }

                let is_member_message = "";
                let priceToDisplay;
                let displayPriceElement = "";

                if (is_member === 0) {
                  is_member_message +=
                    '<span class="gj-member-advantage">Devenez membre : -10%</span>';
                  displayPriceElement +=
                    '<span>Dès <strong> <span class="woocommerce-Price-amount amount"><bdi>' +
                    post.price +
                    '<span class="woocommerce-Price-currencySymbol">€</span></bdi></span> </strong></span>';
                } else {
                  is_member_message +=
                    '<span class="gj-member-advantage">Vous êtes membre : -10%</span>';
                  priceToDisplay = (post.price * 0.9).toFixed(2);
                  displayPriceElement +=
                    '<span>Dès <strong class="no-discounted-price"><span class="woocommerce-Price-amount amount"><bdi>' +
                    post.price +
                    '<span class="woocommerce-Price-currencySymbol">€</span></bdi></span></strong> <strong class="discounted-price"><span class="woocommerce-Price-amount amount"><bdi>' +
                    priceToDisplay +
                    '<span class="woocommerce-Price-currencySymbol">€</span></bdi></span></strong></span>';
                }

                postsHtml +=
                  '<div class="gj-wishlist-post-item gj-wishlist-post-product"';
                if (postIndex > 2 && response.data.posts.length > 3) {
                  postsHtml += 'id="remaining-post-item"';
                } else if (postIndex === 0) {
                  postsHtml += 'id="first-list-item"';
                }
                postsHtml +=
                  ">" +
                  '<div class="gj-wishlist-product-tag">' +
                  '<span class="gj-wishlist-product-badge">Nouveauté</span>' +
                  '<a type="button" class="gj-wishlist-delete-item" data-post-id="' +
                  post.id +
                  '">' +
                  '<img src="/wp-content/uploads/2023/11/trash-can-regular.svg" alt="">' +
                  "</a></div>" +
                  '<a href="' +
                  post.permalink +
                  '" class="gj-wishlist-product-image">' +
                  '<img src="' +
                  post.thumbnail +
                  '" alt="">' +
                  "</a>" +
                  '<div class="gj-wishlist-product-details">' +
                  '<a href="' +
                  post.permalink +
                  '">' +
                  post.name +
                  "</a>" +
                  '<div class="gj-wishlist-product-excerpt">' +
                  post.excerpt +
                  "</div>" +
                  '<div class="gj-wishlist-price-about">' +
                  '<div class="gj-wishlist-price-about-details">' +
                  "<div>" +
                  starsHtml +
                  "<span>0 avis</span>" +
                  "</div>" +
                  is_member_message +
                  "</div>" +
                  displayPriceElement +
                  "</div>" +
                  '<form action="' +
                  post.add_to_cart_url +
                  '" method="post" class="cart">' +
                  '<input type="hidden" name="add-to-cart" value="' +
                  post.id +
                  '">' +
                  '<button type="submit" class="single_add_to_cart_button button alt">' +
                  post.add_to_cart_text +
                  "</button>" +
                  "</form></div></div>";
              } else if (post.type === "recette") {
                // console.log(post.categories)
                // Générer le HTML pour une recette
                postsHtml +=
                  '<div class="gj-wishlist-post-item gj-wishlist-post-recette"';
                if (postIndex > 2 && response.data.posts.length > 3) {
                  postsHtml += 'id="remaining-post-item"';
                } else if (postIndex === 0) {
                  postsHtml += 'id="first-list-item"';
                }
                postsHtml +=
                  ">" +
                  "<div>" +
                  '<a href="' +
                  post.permalink +
                  '" class="gj-wishlist-item-thumbnail">' +
                  '<img src="' +
                  post.thumbnail +
                  '" alt="">' +
                  "</a>" +
                  '<div class="gj-wishlist-item-tag">' +
                  "<div>";
                Object.keys(post.categories).forEach(function (categoryName) {
                  let categoryState = post.categories[categoryName];
                  if (categoryState === "true") {
                    postsHtml +=
                      '<span class="gj-wishlist-recette-categorie">' +
                      categoryName +
                      "</span>";
                  }
                });

                postsHtml +=
                  "</div>" +
                  '<a type="button" class="gj-wishlist-delete-item" data-post-id="' +
                  post.id +
                  '">' +
                  '<img src="/wp-content/uploads/2023/11/trash-can-regular.svg" alt="">' +
                  "</a></div><h3>" +
                  post.title +
                  "</h3><p>" +
                  post.excerpt +
                  "</p></div>" +
                  '<a href="' +
                  post.permalink +
                  '" class="gj-wishlist-post-read-more">Lire la suite</a></div>';
              }

              // console.log(post.type)

              if (postIndex < 3) {
                firstThreePostsHtml += postsHtml;
              } else {
                remainingPostsHtml += postsHtml;
              }
              postIndex++;
            });

            $(".gj-wishlist-tab-content-first-three-posts").removeClass(
              "blinking"
            );
            $(".gj-wishlist-tab-content-remaining-posts").removeClass(
              "blinking"
            );
            // Insérer les HTML dans les éléments respectifs
            $(".gj-wishlist-tab-content-first-three-posts").html(
              firstThreePostsHtml
            );
            $(".gj-wishlist-tab-content-remaining-posts").html(
              remainingPostsHtml
            );

            if (response.data.posts.length > 3) {
              let width = $("#first-list-item").width();
              console.log(width);
              $("#remaining-post-item").width(width);
            }

            $(".gj-wishlist-product-excerpt").each(function () {
              let firstP = $(this).find("p:first").clone();
              if (firstP.length > 0) {
                $(this).empty();
                $(this).append(firstP);
              }
            });

            updatePaginationControls(page, filter, pages);

            updateEventHandlers();
          } else {
            // console.log('Error: ' + response.data.message);
          }
        },
        error: function (error) {
          console.log("AJAX error: ", error);
        },
      });
    }

    /**
     * Function to update the pagination controls based on the current page, filter, and total pages.
     * It dynamically creates page buttons and appends them to the pagination controls.
     * @param {number} page - The current page number to be displayed.
     * @param {string} filter - The active filter id used to determine which set of posts are being displayed.
     * @param {number} pages - The total number of pages available for the current filter.
     */
    function updatePaginationControls(page, filter, pages) {
      $("#gj-wishlist-pagination-controls").empty();
      let currentPage = parseInt(page);

      if (currentPage > 2) {
        $("#gj-wishlist-pagination-controls").append(createPageButton(1));
        if (currentPage > 3) {
          $("#gj-wishlist-pagination-controls").append("<span>...</span>");
        }
      }

      if (currentPage > 1) {
        $("#gj-wishlist-pagination-controls").append(
          createPageButton(currentPage - 1)
        );
      }

      $("#gj-wishlist-pagination-controls").append(
        createPageButton(currentPage).addClass("page-button-active")
      );

      if (currentPage < pages) {
        $("#gj-wishlist-pagination-controls").append(
          createPageButton(currentPage + 1)
        );
      }

      if (currentPage < pages - 1) {
        if (currentPage < pages - 2) {
          $("#gj-wishlist-pagination-controls").append("<span>...</span>");
        }
        $("#gj-wishlist-pagination-controls").append(createPageButton(pages));
      }

      $(".wishlist-filter-button").on("click", function () {
        loadPosts(1);
      });
    }

    /**
     * Function to create a page button.
     * It takes a page number as input and returns a button element with a click event handler to load posts for that page.
     * @param {number} pageNumber - The page number for which the button is created.
     */
    function createPageButton(pageNumber) {
      let button = $("<button>")
        .text(pageNumber)
        .addClass("page-button")
        .attr("id", pageNumber);
      button.on("click", function () {
        loadPosts($(this).attr("id"));
      });
      return button;
    }

    loadFilteredWishlistPosts(1, "all_post", $("#all_post-posts").val());
    updatePaginationControls(
      1,
      "all_post",
      Math.ceil($("#all_post-posts").val() / 12)
    );
  });
})(jQuery);
