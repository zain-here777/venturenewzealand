$(document).on("click", ".place_delete", function () {
    if (confirm('Are you sure? The place that deleted can not restore!'))
        $(this).parent().submit();
});

$(document).on("change", ".place_status", function () {
    let place_id = $(this).attr('data-id');
    let status = $(this).is(':checked');
    updateStatusPlace(place_id, status);
});

$(document).on("change", ".place_highlight", function () {
    let place_id = $(this).attr('data-id');
    let status = $(this).is(':checked');
    updateHighlightPlace(place_id, status);
});

$(document).on("click", ".place_approve", function () {
    let place_id = $(this).attr('data-id');
    if (confirm('Are you sure?')) {
        updateStatusPlace(place_id, 1);
        location.reload();
    }
});

function updateStatusPlace(place_id, status) {
    let data_resp = callAPI({
        url: getUrlAPI('/places/status', 'api'),
        method: "put",
        body: {
            "place_id": place_id,
            "status": status
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
}


function updateHighlightPlace(place_id, status) {
    let data_resp = callAPI({
        url: getUrlAPI('/places/is-highlight','api'),
        method: "put",
        body: {
            "place_id": place_id,
            "is_highlight": status
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
}
