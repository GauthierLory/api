var $rate = $("#rate");
$rate.on("click", function(){
   alert("coucou");
});
/*var $ratingscore = $("#ratingscore");
$ratingscore.on("change", function () {
    if ($client.val() != "") {
        $.ajax({"type": "GET",
            "url": "/component/chronoforms5/?chronoform=saisie_bt&event=ajax_agences&tvout=ajax",
            "data": $client.serialize(),
            "success": function (res) {
                var $agence = $("#agence");
                var prev_val = $agence.val();
                $agence.find("option").remove();
                $.each($.parseJSON(res), function (id, val) {
                    var html = '';
                    if (prev_val == val) {
                        html = 'selected=selected';
                    }
                    html = '<option ' + html + ' value="' + id + '">' + val + '</option>';
                    $agence.append(html);
                });
            } // success
        }); // ajax
    } // if
});*/