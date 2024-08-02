(function ($) {
    'use strict';

    $(document).on("change", ".user_status", function () {
        let user_id = $(this).attr('data-id');
        let status = $(this).is(':checked');

        let data_resp = callAPI({
            url: getUrlAPI('/users/status', 'api'),
            method: "put",
            body: {
                "user_id": user_id,
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

    $(document).on("change", ".user_admin", function () {
        let user_id = $(this).attr('data-id');
        let is_admin = $(this).is(':checked');

        let data_resp = callAPI({
            url: getUrlAPI('/users/role', 'api'),
            method: "put",
            body: {
                "user_id": user_id,
                "is_admin": is_admin ? 1 : 0
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

    $(document).on("click", '.user_delete', function () {
        if (confirm('Are you sure? You want to delete user!')) {
            let user_id = $(this).attr('data-id');
            let data_resp = callAPI({
                url: getUrlAPI(`/users/${user_id}`, 'api'),
                method: "delete",
            });
            data_resp.then(res => {
                if (res.code === 200) {
                    notify(res.message);
                    location.reload();
                } else {
                    console.log(res);
                    notify('Error!', 'error');
                }
            });
        }
    })

})(jQuery);
