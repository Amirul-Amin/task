<?php
session_start();
include 'db.php';

mysqli_query($conn,"DELETE FROM task WHERE id = '".$_GET['id']."'") or die(mysqli_error());

mysqli_query($conn,"UPDATE task SET status = 'Done' WHERE id = '".$_GET['status']."' ") or die(mysqli_error());

if(isset($_POST['save']))
    {
        $name = $_POST['name'];
        mysqli_query($conn,"INSERT into task(name,status,date) values ('$name','pending',now())") or die(mysqli_error());
        echo "<p align=center>Data Added Successfully.</p>";
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To Do</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js" integrity="sha256-XF29CBwU1MWLaGEnsELogU6Y6rcc5nCkhhx89nFMIDQ=" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav id="header" class="bg-white fixed w-full z-10 top-0 shadow">
        <div class="w-full container mx-auto flex flex-wrap items-center mt-0 pt-3 pb-3 md:pb-0">
            <div class="w-1/2 pl-2 md:pl-0">
                <a class="text-gray-900 text-base xl:text-xl no-underline hover:no-underline font-bold" href="#">
                    <i class="fas fa-sun text-violet-600 pr-3"></i> Selamat Datang
                </a>
            </div>
            <div class="w-1/2 pr-0">
                <div class="flex relative inline-block float-right">
                    <div class="relative text-sm">
                        <button id="userButton" class="flex items-center focus:outline-none mr-3">
                            <img class="w-8 h-8 rounded-full mr-4" src="https://uploads.turbologo.com/uploads/design/hq_preview_image/5236277/draw_svg20210628-25121-1cix8av.svg.png" alt="Avatar of User"> <span class="hidden md:inline-block">Hi, <?php echo $_SESSION["username"]; ?> </span>
                            <svg class="pl-2 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                                <g>
                                    <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" />
                                </g>
                            </svg>
                        </button>
                        <div id="userMenu" class="bg-white rounded shadow-md mt-2 absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30 invisible">
                            <ul class="list-reset">
                                <li><a href="logout.php" class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline hover:no-underline">Logout</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="block lg:hidden pr-4">
                        <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-900 hover:border-teal-500 appearance-none focus:outline-none">
                            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <title>Menu</title>
                                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 bg-white z-20" id="nav-content">
                <ul class="list-reset lg:flex flex-1 items-center px-4 md:px-0">
                    <li class="mr-6 my-2 md:my-0">
                        <a href="dashboard.php" class="block py-1 md:py-3 pl-1 align-middle text-grey-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-violet-600">
                            <i class="fas fa-home fa-fw mr-3 "></i><span class="pb-1 md:pb-0 text-sm">Home</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="task.php" class="block py-1 md:py-3 pl-1 align-middle text-violet-600 no-underline hover:text-gray-900 border-b-2 border-violet-600 hover:border-violet-500">
                            <i class="fas fa-tasks fa-fw mr-3 text-violet-600"></i><span class="pb-1 md:pb-0 text-sm">Tasks</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form method="post">
    <div class="container w-full mx-auto pt-20">
        <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
            <div class="flex flex-row flex-wrap flex-grow mt-2">
           
                    <div class="w-full p-3">
                        <div class="bg-white border rounded shadow">
                            <div class="flex space-x-4 w-full p-3">
                            
                                    <div class="grow text-gray-700">
                                        <input class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline" type="text" name="name" placeholder="New Task" id="task"/>
                                    </div>
                                    <div class="text-gray-700">
                                        <input class="inline-flex items-center h-10 px-3 text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800" type="submit" name="save" value="Add">
                                    </div>
                            
                            </div>
                        </div>
                    </div>
               
                <div class="w-full p-3">
                    <div class="bg-white border rounded shadow">
                        <div class="border-b p-3">
                            <h5 class="font-bold uppercase text-gray-600">Tasks Table</h5>
                        </div>
                        <div class="p-5">
                            <table class="w-full p-5 text-gray-700">
                                <thead>
                                    <tr>
                                        <th class="text-left text-blue-900">No</th>
                                        <th class="text-left text-blue-900">Name</th>
                                        <th class="text-left text-blue-900">Date</th>
                                        <th class="text-left text-blue-900">Status</th>
                                        <th class="text-left text-blue-900">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                    $result = mysqli_query($conn,"SELECT * FROM task");
                                        $i=1;
                                        while($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr id="<?php echo $row["id"]; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row["name"]; ?></td>
                                        <td><?php echo $row["date"]; ?></td>
                                        <td><?php echo $row["status"]; ?></td>
                                        <td><a class="text-red-500 no-underline hover:underline" href='task.php?id=<?php echo $row["id"]; ?>'>Delete</a>
                                        <?php if($row["status"] == "pending") {?>
                                        <a class="text-yellow-500 no-underline hover:underline" href='task.php?status=<?php echo $row["id"]; ?>'>done</a></td>
                                        <?php } else {}?>
                                    </tr>
                                    <?php
                                    $i++;
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <script>
        $('body').append('<div style="" id="loadingDiv"><div class="loader">Loading...</div></div>');
        $(window).on('load', function(){
        setTimeout(removeLoader, 2000); 
        });
        function removeLoader(){
            $( "#loadingDiv" ).fadeOut(500, function() {
            $( "#loadingDiv" ).remove(); 
        });  
        }
    </script>
    <script>
    var userMenuDiv = document.getElementById("userMenu");
    var userMenu = document.getElementById("userButton");
    var navMenuDiv = document.getElementById("nav-content");
    var navMenu = document.getElementById("nav-toggle");
    document.onclick = check;
    function check(e) {
        var target = (e && e.target) || (event && event.srcElement);
        if (!checkParent(target, userMenuDiv)) {
            if (checkParent(target, userMenu)) {
                if (userMenuDiv.classList.contains("invisible")) {
                    userMenuDiv.classList.remove("invisible");
                } else { userMenuDiv.classList.add("invisible"); }
            } else {
                userMenuDiv.classList.add("invisible");
            }
        }
        if (!checkParent(target, navMenuDiv)) {
            if (checkParent(target, navMenu)) {
                if (navMenuDiv.classList.contains("hidden")) {
                    navMenuDiv.classList.remove("hidden");
                } else { navMenuDiv.classList.add("hidden"); }
            } else {
                navMenuDiv.classList.add("hidden");
            }
        }
    }
    function checkParent(t, elm) {
        while (t.parentNode) {
            if (t == elm) { return true; }
            t = t.parentNode;
        }
        return false;
    }
    </script>

</body>

</html>








