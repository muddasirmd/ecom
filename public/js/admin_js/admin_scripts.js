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
        var status = $(this).text()
        var section_id = $(this).attr('section_id')
        $.ajax({
            type: 'post',
            url: '/admin/update-section-status/',
            data: {status: status, section_id: section_id},
            success: function(resp){
                if(resp['status'] == 0){
                    $('#section-'+section_id).html('Inactive')
                }else{
                    $('#section-'+section_id).html('Active')
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
     * Products Page Code
     * */
    $('#products').DataTable({'responsive': true});

    $('.updateProductStatus').on('click', function(){
        var status = $(this).text()
        var product_id = $(this).attr('product_id')
        $.ajax({
            type: 'post',
            url: '/admin/update-product-status/',
            data: {status: status, product_id: product_id},
            success: function(resp){
                if(resp['status'] == 0){
                    $('#product-'+product_id).html('Inactive')
                }else{
                    $('#product-'+product_id).html('Active')
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
})