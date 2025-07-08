@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])
@section('content')
    <style>
        /* Manually defined color variations */
        .folder-icon-color {
            color: #FFC107;
            /* original folder color */
            text-shadow: 1px 1px 0px #d39e00;
            /* approx darkened by 7.5% */
        }

        .card-folders .card-body>.breadcrumb {
            margin-left: -1.25em;
            margin-right: -1.25em;
            margin-top: -1.25em;
            border-radius: 0;
        }

        .folder-container {
            text-align: center;
            margin-left: 1rem;
            margin-right: 1rem;
            margin-bottom: 1.5rem;
            width: 100px;
            padding: 0;
            align-self: start;
            background: none;
            border: none;
            outline-color: transparent !important;
            cursor: pointer;
        }

        .folder-icon {
            font-size: 3em;
            line-height: 1.25em;
        }

        .folder-name {
            overflow-wrap: break-word;
            word-wrap: break-word;
            hyphens: auto;
        }

        .flex-column .folder-container {
            display: flex;
            width: auto;
            min-width: 100px;
            text-align: left;
            margin: 0;
            margin-bottom: 1rem;
        }

        .flex-column .folder-icon,
        .flex-column .folder-name {
            display: inline-flex;
        }

        .flex-column .folder-icon {
            font-size: 1.4em;
            margin-right: 1rem;
        }

        .file-icon-color {
            color: #999;
            /* text-shadow: 1px 1px 0px grey; */
        }
    </style>

    <div class="container">
        <div class="card card-folders">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col mr-auto">
                        <h4 class="card-title m-0">User Folders</h4>
                    </div>
                    <div class="col col-auto pr-2">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary" id="btn-list"><i
                                    class="fa fa-th-list fa-lg"></i></button>
                            <button class="btn btn-sm btn-outline-secondary outline-none active" id="btn-grid"><i
                                    class="fa fa-th-large fa-lg"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Folders Container -->
            <div class="card-body" id="foldersGroup">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><i class="far fa-folder"></i>&nbsp; {{ $title }}</li>
                </ol>
                <div id="main-folders" class="d-flex align-items-stretch flex-wrap">
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-folder folder-icon-color"></i>
                            </div>
                            <div class="folder-name">Folder-name</div>
                        </button>
                    </div>
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-folder folder-icon-color"></i>
                            </div>
                            <div class="folder-name">Folder-name</div>
                        </button>
                    </div>
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-folder folder-icon-color"></i>
                            </div>
                            <div class="folder-name">Folder-name</div>
                        </button>
                    </div>
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-folder folder-icon-color"></i>
                            </div>
                            <div class="folder-name">Folder-name-large</div>
                        </button>
                    </div>
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-folder folder-icon-color"></i>
                            </div>
                            <div class="folder-name">Folder-name-extra-large<buttonv>
                                </buttonv>
                            </div>
                        </button>
                    </div>
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-folder folder-icon-color"></i>
                            </div>
                            <div class="folder-name">Folder-name</div>
                        </button>
                    </div>
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-folder folder-icon-color"></i>
                            </div>
                            <div class="folder-name">Folder-name</div>
                        </button>
                    </div>
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-folder folder-icon-color"></i>
                            </div>
                            <div class="folder-name">Folder-name-hyper-extra-large-1235445684121384513</div>
                        </button>
                    </div>
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-folder folder-icon-color"></i>
                            </div>
                            <div class="folder-name">Folder-name</div>
                        </button>
                    </div>
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-folder folder-icon-color"></i>
                            </div>
                            <div class="folder-name">Folder-name</div>
                        </button>
                    </div>
                </div>
            </div>
            <!-- End Folders Container -->
            <!-- Files Container -->
            <div class="card-body d-none" id="filesGroup">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" id="backToFolders"><i class="far fa-folder"></i>&nbsp;
                            Folders</a></li>
                    <li class="breadcrumb-item active">Folder_name_active</li>
                </ol>
                <div id="main-files" class="d-flex align-items-stretch flex-wrap">
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-file file-icon-color"></i>
                            </div>
                            <div class="folder-name">File-name</div>
                        </button>
                    </div>
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-file file-icon-color"></i>
                            </div>
                            <div class="folder-name">File-name-hyper-extra-large-1235445684121384513</div>
                        </button>
                    </div>
                    <div class="d-inline-flex">
                        <button class="folder-container">
                            <div class="folder-icon">
                                <i class="fa fa-file file-icon-color"></i>
                            </div>
                            <div class="folder-name">File-name</div>
                        </button>
                    </div>
                </div>
            </div>
            <!-- End Files Container -->
        </div>
    </div>
@endsection

@push('child_scripts')
    <script>
        $(document).ready(function() {
            // Grid or list selection
            $('#btn-list').on('click', function() {
                $('#main-folders').addClass('flex-column');
                $('#btn-grid').removeClass('active')
                $(this).addClass('active')
            });
            $('#btn-grid').on('click', function() {
                $('#main-folders').removeClass('flex-column');
                $('#btn-list').removeClass('active')
                $(this).addClass('active')
            });
            $('#btn-list').on('click', function() {
                $('#main-files').addClass('flex-column');
                $('#btn-grid').removeClass('active')
                $(this).addClass('active')
            });
            $('#btn-grid').on('click', function() {
                $('#main-files').removeClass('flex-column');
                $('#btn-list').removeClass('active')
                $(this).addClass('active')
            });

            // Open folder and see files
            $('button.folder-container').on('click', function() {
                $('#filesGroup').removeClass('d-none');
                $('#foldersGroup').addClass('d-none')
            });
            $('a#backToFolders').on('click', function() {
                $('#foldersGroup').removeClass('d-none');
                $('#filesGroup').addClass('d-none')
            });
        });
    </script>
@endpush
