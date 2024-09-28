<div class="head-search">
    <input class="search-input" type="search" name="keyword" placeholder="Search for accounts" autocomplete="off">
    <div class="head_search_result" style="display:none"></div>
</div>
<script>

  
    jQuery(document).ready(function($){

        $('.search-input').on('focus', function(){
            $(this).addClass('focused');
            $('.head_search_result').html('Please enter 1 or more characters');
            $('.head_search_result').show();
        });

        /*$('.search-input').on('blur', function(){
            $(this).removeClass('focused');
            $(this).addClass('focused-out');
            $('.head_search_result').html(' ');
            $('.head_search_result').hide();
        });*/

        $('.search-input').on('keyup', function(){
            $('.head_search_result').show();
            var keyword =  $(this).val(); 

            if(keyword.length < 1){
                $('.head_search_result').html('Please enter 1 or more characters');
            }else{
                $('.head_search_result').html('Searching...');
            }

            $.ajax({
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                type: 'POST',
                data: {
                    'action' : 'header_search', 
                    'keyword' : keyword,
                },
                dataType: 'html',
                success: function(response) { 
                    
                    $('.head_search_result').html(response);

                }

            }); 

        });

    });

</script>