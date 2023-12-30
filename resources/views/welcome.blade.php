<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
    </head>
    <body>
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <form id="location-form">
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude">
                            <div id="latitude_error" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude">
                            <div id="longitude_error" class="invalid-feedback"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-5">
                <div class="col-md-6" id="json_results">
                </div>
            </div>
        </div>
        <div id="loader" class="lds-dual-ring d-none overlay"></div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>

            $('#location-form').on('submit', function(event) {
                event.preventDefault();
                $("#json_results").empty();
                getLocation();
            });

            function getLocation() {
                $.ajax({
                    url: "{{ route('api.get.weather.by.lat.lon') }}",
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        'latitude': $('#latitude').val(),
                        'longitude': $('#longitude').val()
                    }),
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    beforeSend: function () {
                        $('#loader').removeClass('d-none')
                    },
                    success: function(data) {
                        var results = JSON.stringify(data, null, 4);
                        $('#json_results').append(`<pre>`+ results +`</pre>`);
                        $('#json_results').css({"background-color": "lightgray", "border": "1px solid", "border-radius": "10px"});
                    },
                    error: function(error) {
                        if (parseInt(error.status) === 422) {
                            if (error.responseJSON.errors.latitude && error.responseJSON.errors.latitude.length > 0) {
                                $('#latitude_error').show();
                                $('#latitude_error').text(error.responseJSON.errors.latitude[0]);
                            }
                            if (error.responseJSON.errors.longitude && error.responseJSON.errors.longitude.length > 0) {
                                $('#longitude_error').show();
                                $('#longitude_error').text(error.responseJSON.errors.longitude[0]);
                            }
                        }
                    },
                    complete: function () {
                        $('#loader').addClass('d-none')
                    },
                });
            }

            removeError();

            function removeError() {
                $('input').focus(function(e) {
                    removeErrorByInputID(e.target.id);
                });
            }

            function removeErrorByInputID(id) {
                $('#' + id).on('focus', function() {
                    $('#' + id + '_error').hide();
                });
            }
        </script>
    </body>
</html>
