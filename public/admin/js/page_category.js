(function ($) {
    'use strict';

    $(document).on("click", ".category_edit", function () {
        $('#parent_id option').show();

        let category_id = $(this).attr('data-id');
        // let category_name = $(this).attr('data-name');
        let translations = JSON.parse($(this).attr('data-translations'));

        translations.forEach(function (value) {
            $("#parent_id option[value='"+value.category_id+"']").hide();
            $(`input[name="${value.locale}[name]"]`).val(value.name);
            $(`input[name="${value.locale}[feature_title]"]`).val(value.feature_title);
            // $(`input[name="${value.locale}[description]"]`).val(value.description);
        });

        let category_slug = $(this).attr('data-slug');
        let category_priority = $(this).attr('data-priority');
        let category_is_feature = $(this).attr('data-isfeature');
        let category_feature_title = $(this).attr('data-featuretitle');
        let category_description = $(this).attr('data-description');
        let category_color_code = $(this).attr('data-colorcode');
        let category_icon_map_marker = $(this).attr('data-icon');
        let category_small_icon = $(this).attr('data-small-icon');
        let seo_title = $(this).attr('data-seotitle');
        let seo_description = $(this).attr('data-seodescription');

        $('#submit_add_category').hide();
        $('#submit_edit_category').show();
        $('#add_category_method').val('PUT');
        $('#category_id').val(category_id);
        // $('#category_name').val(category_name);
        $('#category_slug').val(category_slug);
        $('#category_description').val(category_description);
        $('#category_priority').val(category_priority);
        $('#category_is_feature').val(category_is_feature);
        $('#category_color_code').val(category_color_code);
        $('#category_feature_title').val(category_feature_title);
        $('#preview_icon').attr('src', `/uploads/${category_icon_map_marker}`);
        $('#preview_small_icon').attr('src', `/uploads/${category_small_icon}`);
        $('#seo_title').val(seo_title);
        $('#seo_description').val(seo_description);
        $('.modal-title').html('Edit category');

        if(category_color_code!=""){
            $('#preview_icon').css("background", category_color_code);
        }
        $('#modal_add_category').modal('show');
    });

    $(document).on("click", ".category_delete", function () {
        if (confirm('Are you sure? The category that deleted can not restore!')) {
            $(this).parent().submit();
        }
    });

    $('#btn_add_category').click(function () {
        $('#category_form').trigger("reset");
        $('#parent_id option').show();

        $('#submit_add_category').show();
        $('#submit_edit_category').hide();
        $('#add_category_method').val('POST');
        $('#category_id').val('');
        $('.modal-title').html("Add category");
        $('#modal_add_category').modal('show');
    });

    $(document).on("change", ".category_status", function () {
        let category_id = $(this).attr('data-id');
        let status = $(this).is(':checked');

        let data_resp = callAPI({
            url: getUrlAPI('/category/status', 'api'),
            method: "put",
            body: {
                "category_id": category_id,
                "status": status ? 1 : 0
            }
        });
        data_resp.then(res => {
            if (res.code === 200) {
                notify(res.message);
            } else {
                console.log(res);
                notify('Error!', 'error');
            }
        });
    });

    $(document).on("change", ".category_is_feature", function () {
        let category_id = $(this).attr('data-id');
        let is_feature = $(this).is(':checked');

        let data_resp = callAPI({
            url: getUrlAPI('/category/is-feature', 'api'),
            method: "put",
            body: {
                "category_id": category_id,
                "is_feature": is_feature ? 1 : 0
            }
        });
        data_resp.then(res => {
            if (res.code === 200) {
                notify(res.message);
            } else {
                console.log(res);
                notify('Error!', 'error');
            }
        });
    });


    $('#category_name').keyup(function () {
        let category_name = $(this).val();
        let slug = toSlug(category_name);
        $('#category_slug').val(slug);
    });

    $('#icon_map_marker').change(function () {
        previewUploadImage(this, 'preview_icon')
    });
    $('#small_icon').change(function () {
        previewUploadImage(this, 'preview_small_icon')
    });

})(jQuery);
