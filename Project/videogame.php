<?php
/*
    PROJECT: PUBLIC LIBRARY.
    LUIS J. BRAVO ZÚÑIGA.
    VIDEOGAME PAGE (CRUD PAGE).
*/
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>REX | Videogames</title>
        <link href="tools/boostrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="tools/css/videogame/styles.css" rel="stylesheet" type="text/css"/>
        <link href="tools/css/modal/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body onload="javascript:init()">
        <!-- The Message Modal -->
        <div id="myModal" class="modal">
            <div class="modal-content" style=" width: 50%;">
                <span class="close">&times;</span>
                <p class="info-error" id="text"></p>
            </div>
        </div>
        <!-- The Add Modal -->
        <div id="modalAdd" class="modal">
            <div class="modal-content" style=" width: 50%;">
                <form id="formAdd">
                    <div class="modal-header">
                        <h2 id="modalTitle" class="modal-title"></h2></div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-row">
                                <div class="col"><label>ID</label><input class="form-control" type="text" id="id"></div>
                            </div>
                            <div class="form-row">
                                <div class="col"><label>Title</label><input class="form-control" type="text" id="title" autocomplete="off" required></div>
                            </div>
                            <div class="form-row">
                            <div class="col"><label>Platform</label>
                                    <select id="platform" class="form-control">
                                        <option value="null" disabled selected>Choose</option>
                                    </select>
                                </div>
                                <div class="col"><label>Genre</label>
                                    <select id="genre" class="form-control">
                                        <option value="null" disabled selected>Choose</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col"><label>Price</label><input class="form-control" type="number" id="price" min="1" step="0.25" required></div>
                            </div>
                            <div class="form-row">
                                <div class="col"><label>Quantity</label><input class="form-control" type="number" id="quantity" min="1" step="1" required></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" style="background-color: #0069d9; min-width: 20%;"type="submit">Ready</button>
                        <button class="btn btn-light" type="button" data-dismiss="modal" style="background-color: #cccccc; min-width: 20%;" onclick="javascript:closeModal();">Close</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row row-space">
                <div class="col back">
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row row-space" >
                <div class="col d-flex justify-content-center align-items-center align-content-center">
                    <p class="text-center title">REX VIDEO GAME STORE</br></p>
                </div>
            </div>
            <div class="row row-space" >
                <div class="col d-flex justify-content-center align-items-center align-content-center">
                    <p class="text-center subtitle">SEARCH A VIDEO GAME</p>
                </div>
            </div>
            <div class="row row-space">
                <div class="col">
                    <div class="row row-space">
                        <div class="col">
                            <div class="row row-space" >
                                <div class="col">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text" style="width:100px;">ID</span></div><input class="form-control" id="idFilter" type="number" name="idFilter" placeholder="1000"autocomplete="off" min="1000" step="1" style="margin:0px;width:635.469px;">
                                        <div class="input-group-append"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space" >
                                <div class="col">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text" style="width:100px;">Title</span></div><input class="form-control" id="titleFilter" type="text" name="titleFilter" placeholder="God of War 3" autocomplete="off" style="width:635.469px;">
                                        <div class="input-group-append"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space" >
                                <div class="col">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:100px;">Platform</span></div>
                                        <select id="platformFilter" class="form-control">
                                        <option value="null" selected>Choose</option>
                                        </select>
                                        <div class="input-group-append"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="row row-space" >
                        <div class="col d-flex justify-content-center align-items-center align-content-center"><button class="btn btn-primary operation-button" type="button" onclick="javascript:filter()">Search</button></div>
                    </div>
                    <div class="row row-space" >
                        <div class="col d-flex justify-content-center align-items-center align-content-center"><button class="btn btn-primary operation-button" type="button" onclick="javascript:reset()">Reset</button></div>
                    </div>
                    <div class="row row-space" >
                        <div class="col d-flex justify-content-center align-items-center align-content-center"><button class="btn btn-primary operation-button" type="button" onclick="javascript:showModalAdd()">Add</button></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row row-space" style="padding:20px;">
                <div class="col d-flex justify-content-center align-items-center align-content-center">
                    <p class="text-center subtitle">LIST OF VIDEO GAMES</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="color:rgb(148,75,34);">
                        <tr class="d-table-row justify-content-center align-items-center align-content-center" style="color:rgb(0,0,0);">
                            <th class="header-row">ID</th>
                            <th class="header-row">Title</th>
                            <th class="header-row">Platform</th>
                            <th class="header-row">Genre</th>
                            <th class="header-row">Price</th>
                            <th class="header-row">Quantity</th>
                            <th class="header-row">Delete</th>
                            <th class="header-row">Update</th>
                        </tr>
                    </thead>
                    <tbody class="body-table" id = "tableBody">
                    </tbody>
                </table>
            </div>
        </div>
        <script src="tools/js/jquery.min.js" type="text/javascript"></script>
        <script src="tools/boostrap/bootstrap.min.js" type="text/javascript"></script>
        <script src="tools/js/videogame/admin_videogame.js" type="text/javascript"></script>
    </body>

</html>