(function ($) {
    'use strict';

    $(document).on("click", ".country_edit", function () {
        let country_id = $(this).attr('data-id');
        let country_name = $(this).attr('data-name');
        let country_slug = $(this).attr('data-slug');
        let country_description = $(this).attr('data-description');
        let country_banner = $(this).attr('data-banner');
        let country_map = $(this).attr('data-countrymap');
        let country_map_tile = $(this).attr('data-countrymap_tile');
        let country_about = $(this).attr('data-about');
        let country_website = $(this).attr('data-website');
        let country_video = $(this).attr('data-video');

        $('#submit_add_country').hide();
        $('#submit_edit_country').show();
        $('#add_country_method').val('PUT');
        $('#country_id').val(country_id);
        $('#country_name').val(country_name);
        $('#country_slug').val(country_slug);
        $('#country_description').val(country_description);
        $('#country_about').val(country_about);
        $('#country_website').val(country_website);
        $('#country_video').val(country_video);

        $('.modal-title').html("Edit region");
        $('#modal_add_country').modal('show');
        if (country_map) {
            $('#preview_map').attr('src', `/assets/images/countries/${country_map}`);
        } else {
            $('#preview_map').attr('src', `https://via.placeholder.com/120x150?text=VentureNZ`);
        }

        if (country_map_tile) {
            $('#preview_map_tile').attr('src', `/assets/images/countries/${country_map_tile}`);
        } else {
            $('#preview_map_tile').attr('src', `https://via.placeholder.com/120x150?text=VentureNZ`);
        }

        if (country_banner) {
            $('#preview_banner').attr('src', `/uploads/${country_banner}`);
        } else {
            $('#preview_banner').attr('src', `https://via.placeholder.com/372x150?text=VentureNZ`);
        }
    });

    $(document).on("click", ".country_delete", function () {
        if (confirm('Are you sure? The region that deleted can not restore!')) {
            $(this).parent().submit();
        }
    });

    $('#btn_add_country').click(function () {
        $('#submit_add_country').show();
        $('#submit_edit_country').hide();
        $('#add_country_method').val('POST');
        $('#country_id').val('');
        $('#country_name').val('');
        $('#country_slug').val('');
        $('.modal-title').html("Add region");
        $('#modal_add_country').modal('show');
    });

    $('#country_name').keyup(function () {
        let country_name = $(this).val();
        let slug = toSlug(country_name);
        $('#country_slug').val(slug);
    });
    $('#country_map').change(function () {
        previewUploadImage(this, 'preview_map')
    });

    $('#country_map_tile').change(function () {
        previewUploadImage(this, 'preview_map_tile')
    });

    $('#country_banner').change(function () {
        previewUploadImage(this, 'preview_banner')
    });
})(jQuery);
