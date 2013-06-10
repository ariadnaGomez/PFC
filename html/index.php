<html>
    <head><link href='../css/images/rdf.ico' rel='shortcut icon' type='image/png'></head>
    <title>Bibliographic Application</title>
    <link rel="stylesheet" href="../css/styles/layout.css" type="text/css" />
    <script type="text/javascript" src="../css/scripts/jquery-ui-1.8.12.custom.min.js"></script>
    <script type="text/javascript" src="../css/scripts/jquery-1.4.1.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script type="text/javascript" src="../js/searchBNE.js"></script>
    <script type="text/javascript" src="../js/searchDBPedia.js"></script>
    <script type="text/javascript" src="../js/updateData.js"></script>
    <script type="text/javascript" src="../js/main.js"></script>



    <body id="top">

        <div class="wrapper col1">
            <div id="header" class="clear">
                <div class="fl_left">
                    <h1><a href="https://github.com/ariadnaGomez/PFC">Bibliographic Application</a></h1>
                    <p>Aplicaci&oacute;n bibliogr&aacute;fica usando Linked Data</p>

                </div>




            </div>
        </div>
        <!-- ####################################################################################################### -->
        <div class="wrapper col1">
            <div id="topbar" class="clear">


                <div action="#" method="post" id="search"> 
                    <fieldset>
                        <legend>Site Search</legend>
                        <input id="searchInput"  placeholder="Search by author"/>
                        <input type="image" id="go" src="../css/images/search.gif" alt="Search" />
                    </fieldset>
                </div> 
            </div>
        </div>
        <div id="page1" class="container1">


            <!--#######################################################################################################--> 
            <h1 id="searchTitle"></h1>
            <div id="loading_gif" class="hidden">
                <img id="loading_img" src="../css/images/loading.gif" alt="" />
            </div>
            <div id="content">

            </div>
            <div id="loading_gif" class="hidden">
                <img id="loading_img" src="../css/images/loading.gif" alt="" />
            </div>
        </div>


        <div id="copyright" class="clear">
            <p class="fl_left"id="update_link">Update Authors List</p>
            <p class="fl_right hidden" id='updated'>
                Updated successfully.
            </p>
            <p class="fl_right hidden" id="updated_not">
                Unable to update authors list. Try again later
            </p>
            <p class="fl_right"><div id="updating_gif" class="hidden">
                <img id="update_img" src="../css/images/ajax-loader.gif" alt="" />
            </div>
        </div>

    </body>
</html>

