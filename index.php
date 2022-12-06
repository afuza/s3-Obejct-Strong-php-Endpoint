<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing Upload S3</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js" integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="container-fluid">

        <div class="w-100 pt-5">
            <div class="col-lg-6 col-md-8 col-sm-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h5>Upload File S3 Obcjet Storage</h5>
                        </div>
                        <form action="s3-upload.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">only file ext Images</label>
                                <input class="form-control" name="file" type="file" id="formFile">
                            </div>
                            <input type="submit" value="Upload Image" class="btn btn-primary" name="submit">
                        </form>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="col-lg-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h5>File List</h5>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Key</th>
                                        <th scope="col">Last Modified</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $.ajax({
                type: 'GET',
                url: 's3-data.php',
                data: {},
                dataType: 'json',
                error: function(a, b, c) {

                },
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, value) {
                        html += '<tr>';
                        html += '<th scope="row">' + (index + 1) + '</th>';
                        html += '<td>' + value.Key + '</td>';
                        html += '<td>' + value.LastModified + '</td>';
                        html += '<td><a href="s3-Delete.php?key=' + value.Key + '" class="btn btn-danger">Hapus</a></td>';
                        html += '</tr>';
                    });
                    $('tbody').html(html);
                }
            });
        });
    </script>
</body>

</html>