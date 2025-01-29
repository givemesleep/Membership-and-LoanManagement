<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Index Sample</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidenav {
            height: 100%;
            width: 250px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            padding-top: 20px;
        }

        .sidenav a {
            padding: 8px 8px 8px 16px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .modal-body {
            display: flex;
        }
    </style>
</head>
<body>

<!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Open Modal with Sidenav
</button>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal with Sidenav</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form>
                    <div class="sidenav">
                        <a href="#section1">Section 1</a>
                        <a href="#section2">Section 2</a>
                        <a href="#section3">Section 3</a>
                        <a href="#section4">Section 4</a>
                    </div>
                    <div style="margin-left:260px; padding:20px;">
                        <h2>Content Area</h2>
                        <p>Click on the links in the sidenav to navigate to different sections.</p>
                        <div id="section1">
                            <h3>Section 1</h3>
                            <p>Content for section 1.</p>
                        </div>
                        <div id="section2">
                            <h3>Section 2</h3>
                            <p>Content for section 2.</p>
                        </div>
                        <div id="section3">
                            <h3>Section 3</h3>
                            <p>Content for section 3.</p>
                        </div>
                        <div id="section4">
                            <h3>Section 4</h3>
                            <p>Content for section 4.</p>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>