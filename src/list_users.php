   <?php
require('../config/database.php');

   ?>
   <!DOCTYPE html>
    <html lang="en">
        <head>
            
    </head>
    <body>
        <h1>List of Users</h1>
     <table border="1" align="center">
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Mobile Phone</th>
        <th>Status</th>
        <th>Photo</th>
        <th>Action</th>
    </tr>

    <tr>
        <td>1</td>
        <td>John</td>
        <td>Doe</td>
        <td>john.doe@example.com</td>
        <td>1234567890</td>
        <td>Active</td>

        <!-- FOTO -->
        <td>
            <img src="profile_photos/user1default.png" alt="User Photo" width="50">
        </td>

        <!-- ACCIONES -->
        <td>
            <a href="edit_user.php?id=1">
                <img src="icons/edit.png" alt="Edit" width="20">
            </a>

            <a href="delete_user.php?id=1">
                <img src="icons/delete.png" alt="Delete" width="20">
            </a>
        </td>
    </tr>
</table>
            
            
                
            <?php
            
            

