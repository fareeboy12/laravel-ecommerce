<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@yield('title')</title>
        <meta name="keywords" content="HTML5 Template">
        <meta name="description" content="Molla - Bootstrap eCommerce Template">
        <meta name="author" content="p-themes">
        <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/icons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/icons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/icons/favicon-16x16.png">
        <link rel="manifest" href="/assets/images/icons/site.html">
        <link rel="mask-icon" href="/assets/images/icons/safari-pinned-tab.svg" color="#666666">
        <link rel="shortcut icon" href="/assets/images/icons/favicon.ico">
        <meta name="apple-mobile-web-app-title" content="Molla">
        <meta name="application-name" content="Molla">
        <meta name="msapplication-TileColor" content="#cc9966">
        <meta name="msapplication-config" content="/assets/images/icons/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" href="/assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css">
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
        <link rel="stylesheet" href="/assets/css/plugins/owl-carousel/owl.carousel.css">
        <link rel="stylesheet" href="/assets/css/plugins/magnific-popup/magnific-popup.css">
        <link rel="stylesheet" href="/assets/css/plugins/jquery.countdown.css">
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="/assets/css/skins/skin-demo-2.css">
        <link rel="stylesheet" href="/assets/css/demos/demo-2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
    .edit-input {
        border: none;
        background-color: transparent;
    }
    .edit-input.editing {
        border: 1px solid #ced4da;
        background-color: #fff;
    }
</style>
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="container">
                @yield('content')
            </main>
        </div>

        @stack('modals')

    <script src="/assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <script src="/assets/js/jquery.hoverIntent.min.js"></script>
    <script src="/assets/js/jquery.waypoints.min.js"></script>
    <script src="/assets/js/superfish.min.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/js/jquery.plugin.min.js"></script>
    <script src="/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/assets/js/jquery.countdown.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/demos/demo-2.js"></script>
    <script>
        var product_categories = new Choices('#product_category', {
            removeItemButton: true,
            loadingText: 'Loading...',
            noResultsText: 'No results found',
            noChoicesText: 'No choices to choose from',
            itemSelectText: 'Press to select',
            uniqueItemText: 'Only unique values can be added',
            renderSelectedChoices: 'auto',
        }); 

        var upsell_items = new Choices('#upsell_items', {
            removeItemButton: true,
            loadingText: 'Loading...',
            noResultsText: 'No results found',
            noChoicesText: 'No choices to choose from',
            itemSelectText: 'Press to select',
            uniqueItemText: 'Only unique values can be added',
            renderSelectedChoices: 'auto',
        }); 

        var crosssell_items = new Choices('#crosssell_items', {
            removeItemButton: true,
            loadingText: 'Loading...',
            noResultsText: 'No results found',
            noChoicesText: 'No choices to choose from',
            itemSelectText: 'Press to select',
            uniqueItemText: 'Only unique values can be added',
            renderSelectedChoices: 'auto',
        });
        
        
        jQuery(document).ready(function () {
      ImgUpload();
      });

      function ImgUpload() {
        var imgWrap = "";
        var imgArray = [];

        $('.upload__inputfile').each(function () {
          $(this).on('change', function (e) {
            imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
            var maxLength = $(this).attr('data-max_length');

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);
            var iterator = 0;
            filesArr.forEach(function (f, index) {

              if (!f.type.match('image.*')) {
                return;
              }

              if (imgArray.length > maxLength) {
                return false
              } else {
                var len = 0;
                for (var i = 0; i < imgArray.length; i++) {
                  if (imgArray[i] !== undefined) {
                    len++;
                  }
                }
                if (len > maxLength) {
                  return false;
                } else {
                  imgArray.push(f);

                  var reader = new FileReader();
                  reader.onload = function (e) {
                    var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                    imgWrap.append(html);
                    iterator++;
                  }
                  reader.readAsDataURL(f);
                }
              }
            });
          });
        });

        $('body').on('click', ".upload__img-close", function (e) {
          var file = $(this).parent().data("file");
          for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i].name === file) {
              imgArray.splice(i, 1);
              break;
            }
          }
          $(this).parent().parent().remove();
        });
      }
    </script>

<script>

    async function fetchCoupons() {
      try {
            const response = await fetch("{{ route('coupons.index') }}");
            const coupons = await response.json();

            let tableRows = '';

            coupons.forEach((coupon, index) => {
                tableRows += `
                    <tr data-id="${coupon.id}">
                        <th scope="row" class="p-2">${index + 1}</th>
                        <td class="p-2">
                            <input type="text" name="coupon_code" value="${coupon.coupon_code}" class="form-control m-0 edit-input" disabled>
                        </td>
                        <td class="p-2">
                            <input type="number" name="coupon_price" value="${coupon.coupon_price}" class="form-control m-0 edit-input" disabled>
                        </td>
                        <td class="p-2">
                            <button type="button" class="btn-edit">
                                <i class="icon-edit"></i>
                            </button>
                            <button type="button" class="btn-save" style="display: none;">
                              <i class="far fa-save"></i>
                            </button>
                        </td>
                        <td class="p-2">
                            <form action="{{ route('coupons.destroy', '') }}/${coupon.id}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove">
                                    <i class="icon-close"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                `;
            });

            const tableBody = document.querySelector("table > tbody");
            tableBody.innerHTML = tableRows;

            // Reattach event listeners to the edit buttons
            attachEditButtonListeners();

        } catch (error) {
            console.error("Error fetching coupons:", error);
        }
    }

    function attachEditButtonListeners() {
  const editButtons = document.querySelectorAll('.btn-edit');
  const saveButtons = document.querySelectorAll('.btn-save');

  editButtons.forEach((btn, index) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const row = btn.closest('tr');
      const inputs = row.querySelectorAll('.edit-input');

      inputs.forEach(input => {
        input.removeAttribute('disabled');
        input.classList.add('editing');
      });

      btn.style.display = 'none';
      saveButtons[index].style.display = 'inline-block';
    });
  });

  saveButtons.forEach((btn, index) => {
    btn.addEventListener('click', async (e) => {
      e.preventDefault();
      const row = btn.closest('tr');
      const inputs = row.querySelectorAll('.edit-input');
      const id = row.getAttribute('data-id');

      inputs.forEach(input => {
        input.setAttribute('disabled', '');
        input.classList.remove('editing');
      });

      const couponCode = row.querySelector('input[name="coupon_code"]').value;
      const couponPrice = row.querySelector('input[name="coupon_price"]').value;

      try {
        const response = await fetch(`{{ url('/coupons/') }}/${id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
          },
          body: JSON.stringify({
            coupon_code: couponCode,
            coupon_price: couponPrice,
          }),
        });

        const data = await response.json();

        if (data.success) {
          console.log(data.success);
          fetchCoupons();
        } else {
          console.error('Error updating coupon');
        }
      } catch (error) {
        console.error('Error updating coupon:', error);
      }

      // Hide save button and display edit button again
      btn.style.display = 'none';
      editButtons[index].style.display = 'inline-block';
    });
  });
}



    document.addEventListener('DOMContentLoaded', () => {
      fetchCoupons();
    });
</script>

    <style>
      .upload__inputfile {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
      }
      .upload__btn {
        display: inline-block;
        font-weight: 600;
        color: #fff;
        text-align: center;
        min-width: 116px;
        padding: 5px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid;
        background-color: #4045ba;
        border-color: #4045ba;
        border-radius: 10px;
        line-height: 26px;
        font-size: 14px;
      }
      .upload__btn p{
          color: #fff;
      }
      .upload__btn:hover {
        background-color: unset;
        color: #4045ba;
        transition: all 0.3s ease;
      }

      .upload__btn:hover p{
          color: #4045ba;
      }
      .upload__btn-box {
        margin-bottom: 10px;
      }
      .upload__img-wrap {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
      }
      .upload__img-box {
        width: 200px;
        padding: 0 10px;
        margin-bottom: 12px;
      }
      .upload__img-close {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.5);
        position: absolute;
        top: 10px;
        right: 10px;
        text-align: center;
        line-height: 24px;
        z-index: 1;
        cursor: pointer;
      }
      .upload__img-close:after {
        content: "✖";
        font-size: 14px;
        color: white;
      }

      .img-bg {
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        position: relative;
        padding-bottom: 100%;
      }
    </style>
    </body>
</html>
