$(function(){

    // Check Admin Password is Correct or not
    $("#current_password").on("keyup", function(){
        var current_password = $("#current_password").val();
        
        $.ajax({
            type: 'post',
            url: '/admin/check-current-password/',
            data: {current_password: current_password},
            success: function(res){
                if(res){
                    $("#current_password").css({'border': '2px solid #01cd11'})
                }
                else{
                    $("#current_password").css({'border': '2px solid #dd3434'})
                }
            },
            error: function(err){
                alert(err)
            }
        })
    });

     /** 
     * Sections Page Code
     * */
     $('#sections').DataTable({'responsive': true});

    $('.updateSectionStatus').on('click', function(){
        var status = $(this).children("i").attr('status')
        var section_id = $(this).attr('section_id')
        $.ajax({
            type: 'post',
            url: '/admin/update-section-status/',
            data: {status: status, section_id: section_id},
            success: function(resp){
                if(resp['status'] == 0){
                    $('#section-'+section_id).html('<i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i>')
                }else{
                    $('#section-'+section_id).html('<i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i>')
                }
            },
            error: function(err){
                alert(err)
            }
        })
    });


    /** 
     * Categories Page Code
     * */
    $('#categories').DataTable({'responsive': true});
    //Initialize Select2 Elements
    $('.select2').select2();

    $('.updateCategoryStatus').on('click', function(){
        var status = $(this).text()
        var category_id = $(this).attr('category_id')
        $.ajax({
            type: 'post',
            url: '/admin/update-category-status/',
            data: {status: status, category_id: category_id},
            success: function(resp){
                if(resp['status'] == 0){
                    $('#category-'+category_id).html('Inactive')
                }else{
                    $('#category-'+category_id).html('Active')
                }
            },
            error: function(err){
                alert(err)
            }
        });
    });
    
    // append categories level (sub-categories)
    $('#section_id').on('change', function(){
        var sectionID = $(this).val();
        $.ajax({
            type: 'post',
            url: '/admin/append-categories-level',
            data: {section_id: sectionID},
            success: function(resp){
              
                $('#appendCategoriesLevel').html(resp);
            },
            error: function(err){
                alert(err)
            }
        });
    });


    /** 
         PRODUCTS PAGE CODE
    * */
    $('#products').DataTable({'responsive': true});

    $('.updateProductStatus').on('click', function(){
        var status = $(this).children("i").attr('status')
        var product_id = $(this).attr('product_id')
        $.ajax({
            type: 'post',
            url: '/admin/update-product-status/',
            data: {status: status, product_id: product_id},
            success: function(resp){
                if(resp['status'] == 0){
                    $('#product-'+product_id).html('<i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i>')
                }else{
                    $('#product-'+product_id).html('<i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i>')
                }
            },
            error: function(err){
                alert(err)
            }
        });
    });

    /*
    *   Confirm Delete Alert
    */
   $('.confirmDelete').on('click', function(){
    let record = $(this).attr('record')
    let recordId = $(this).attr('recordid')

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
        //   Swal.fire(
        //     'Deleted!',
        //     'Your file has been deleted.',
        //     'success'
        //   )
        window.location.href = "/admin/delete-"+record+"/"+recordId
        }
      })
   });

   /*
        PRODUCT ATTRIBUTES
   */
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div class="my-1"><input type="text" name="size[]" value="" style="width:120px" placeholder="Size"/> <input type="text" name="sku[]" value="" style="width:120px" placeholder="SKU"/> <input type="number" name="price[]" value="" style="width:120px" placeholder="Price"/> <input type="number" name="stock[]" value="" style="width:120px" placeholder="Stock"/> <a href="javascript:void(0);" class="remove_button">Delete</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).on('click', function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

    // Product Attributes Status
    $('.updateProductAttributeStatus').on('click', function(){
        var status = $(this).text()
        var attr_id = $(this).attr('product_attribute_id')
        $.ajax({
            type: 'post',
            url: '/admin/update-product-attribute-status/',
            data: {status: status, attr_id: attr_id},
            success: function(resp){
                if(resp['status'] == 0){
                    $('#product-attribute-'+attr_id).html('Inactive')
                }else{
                    $('#product-attribute-'+attr_id).html('Active')
                }
            },
            error: function(err){
                alert(err)
            }
        });
    });

    /* 
        PRODUCT IMAGES
    */

    // Product Images Status
    $('.updateProductImageStatus').on('click', function(){
        var status = $(this).text()
        var image_id = $(this).attr('product_image_id')
        $.ajax({
            type: 'post',
            url: '/admin/update-product-image-status/',
            data: {status: status, image_id: image_id},
            success: function(resp){
                if(resp['status'] == 0){
                    $('#product-image-'+image_id).html('Inactive')
                }else{
                    $('#product-image-'+image_id).html('Active')
                }
            },
            error: function(err){
                alert(err)
            }
        });
    });


        /** 
            BRAND PAGE CODE
        */
         $('#brands').DataTable({'responsive': true});

         $('.updateBrandStatus').on('click', function(){
             var status = $(this).children("i").attr('status')
             var brand_id = $(this).attr('brand_id')
             $.ajax({
                 type: 'post',
                 url: '/admin/update-brand-status/',
                 data: {status: status, brand_id: brand_id},
                 success: function(resp){
                     if(resp['status'] == 0){
                         $('#brand-'+brand_id).html('<i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i>')
                     }else{
                         $('#brand-'+brand_id).html('<i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i>')
                     }
                 },
                 error: function(err){
                     alert(err)
                 }
             });
         });
     
        //  /*
        //  *   Confirm Delete Alert
        //  */
        // $('.confirmDelete').on('click', function(){
        //  let record = $(this).attr('record')
        //  let recordId = $(this).attr('recordid')
     
        //  Swal.fire({
        //      title: 'Are you sure?',
        //      text: "You won't be able to revert this!",
        //      icon: 'warning',
        //      showCancelButton: true,
        //      confirmButtonColor: '#3085d6',
        //      cancelButtonColor: '#d33',
        //      confirmButtonText: 'Yes, delete it!'
        //    }).then((result) => {
        //      if (result.isConfirmed) {
        //      //   Swal.fire(
        //      //     'Deleted!',
        //      //     'Your file has been deleted.',
        //      //     'success'
        //      //   )
        //      window.location.href = "/admin/delete-"+record+"/"+recordId
        //      }
        //    })
        // });


})