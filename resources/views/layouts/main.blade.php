<!doctype html>
<html dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}" lang="{{ App::currentLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @if (App::currentLocale() == 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css"
            integrity="sha384-nU14brUcp6StFntEOOEBvcJm4huWjB0OcIeQ3fltAfSmuZFrkAif0T+UtNGlKKQv" crossorigin="anonymous">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    @endif
    <style>
        /* Custom modal styles */
        #custom-modal,
        #custom-modal2 {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content,
        .modal-content2 {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 25%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* Custom input style */
        .aaa,
        .aaa2 {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            font-size: 14px;
        }

        /* Button styles */
        .button-container,
        .button-container2 {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .modal-button,
        .modal-button2 {
            margin: 0 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .save-button,
        .save-button2 {
            background-color: #27ae60;
            color: white;
        }

        .close-button,
        .close-button2 {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>

<body>
    <header class="mb-5">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="{{ route('classrooms.index') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('classrooms.create') }}">Create Classroom</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Language
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.updateLang', 'en') }}">English</a>
                                </li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="{{ route('profile.updateLang', 'ar') }}">Arabic</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="me-3">
                        {{ Auth::user()->name }}
                    </div>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                <svg class="bi" width="30" height="24">
                    <use xlink:href="#bootstrap"></use>
                </svg>
            </a>
            <span class="mb-3 mb-md-0 text-body-secondary">© 2023 {{ config('app.name') }}, Inc</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24"
                        height="24">
                        <use xlink:href="#twitter"></use>
                    </svg></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24"
                        height="24">
                        <use xlink:href="#instagram"></use>
                    </svg></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24"
                        height="24">
                        <use xlink:href="#facebook"></use>
                    </svg></a></li>
        </ul>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ttttLink = document.getElementById('tttt');
            var customModal = document.getElementById('custom-modal');
            var userInputField = document.getElementById('user-input');
            var modalSave = document.getElementById('modal-save');
            var modalClose = document.getElementById('modal-close');

            var ttLink = document.getElementById('tt');
            var customModal2 = document.getElementById('custom-modal2');
            var userInputField2 = document.getElementById('user-input2');
            var modalSave2 = document.getElementById('modal-save2');
            var modalClose2 = document.getElementById('modal-close2');

            ttttLink.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the default link behavior
                userInputField.value = ''; // Clear previous input
                customModal.style.display = 'flex';
            });

            modalClose.addEventListener('click', function() {
                customModal.style.display = 'none';
            });

            userInputField.addEventListener('keydown', function(event) {
                event.stopPropagation(); // Prevent closing the modal on Enter key
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('reject-button')) {
                    e.preventDefault(); // Prevent the default link behavior
                    let topicId = e.target.getAttribute('data-topic-id');
                    let classroomId = document.querySelector('.ccc').getAttribute('data-classroom-id');
                    userInputField2.value = ''; // Clear previous input
                    customModal2.style.display = 'flex';
                    // Use the topicId variable to update the form action URL
                    var form = customModal2.querySelector('form');
                    form.action = "/classrooms/" + classroomId + "/topics/" +
                        topicId; // Update the action URL
                }
            });

            modalClose2.addEventListener('click', function() {
                customModal2.style.display = 'none';
            });

            userInputField2.addEventListener('keydown', function(event) {
                event.stopPropagation(); // Prevent closing the modal on Enter key
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdn.tiny.cloud/1/cdexc5550nj4jyyd76ey4aom8awzpbvhgcxfnca14b7ypsp3/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                "See docs to implement AI Assistant")),
        });
    </script>

</body>

</html>
