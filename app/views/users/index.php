<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Management Module</title>

    <style>

        /* =================================
           BASIC PAGE SETTINGS
           ================================= */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            /* Increased spacing around the whole page */
            padding: 60px 35px;

            font-family: Arial, sans-serif;

            /* Dark ocean background */
            background: #06141f;

            color: #e8fbff;
        }

        /* Main content width */
        .container {
            max-width: 1100px;
            margin: auto;
        }


        /* =================================
           HEADER
           ================================= */

        .header {
            /* More space below the header */
            margin-bottom: 35px;
        }

        .header h1 {
            margin: 0;

            /* Larger title spacing */
            letter-spacing: 2px;

            color: #00eaff;

            font-size: 34px;
            font-weight: 700;

            /* Neon glow */
            text-shadow:
                0 0 5px #00eaff,
                0 0 15px #00eaff;
        }

        .header p {
            /* More space between title and subtitle */
            margin-top: 12px;

            color: #83c9d8;
            font-size: 15px;

            letter-spacing: 1px;
        }

        /* Ocean wave decoration */
        .wave {
            color: #00eaff;
            margin-right: 10px;

            text-shadow:
                0 0 5px #00eaff,
                0 0 12px #00eaff;
        }


        /* =================================
           TABLE CARD
           ================================= */

        .card {
            background: #0a202d;

            /* Increased inner spacing */
            padding: 30px;

            border-radius: 18px;

            /* Neon border */
            border: 1px solid #00d9ff;

            /* Neon glow around the card */
            box-shadow:
                0 0 8px rgba(0, 234, 255, 0.5),
                0 0 25px rgba(0, 234, 255, 0.15);
        }

        /* Prevents table from breaking on mobile */
        .table-wrapper {
            overflow-x: auto;
        }


        /* =================================
           TABLE
           ================================= */

        table {
            border-collapse: separate;
            border-spacing: 0;

            width: 100%;
        }

        /* Table header */
        th {
            background: #062b3a;

            color: #00eaff;

            /* Increased cell spacing */
            padding: 17px 20px;

            text-align: left;

            font-size: 14px;

            letter-spacing: 1px;

            border-bottom: 1px solid #00d9ff;

            text-shadow:
                0 0 5px rgba(0, 234, 255, 0.8);
        }

        /* Rounded top corners */
        th:first-child {
            border-radius: 10px 0 0 0;
        }

        th:last-child {
            border-radius: 0 10px 0 0;
        }


        /* =================================
           TABLE DATA
           ================================= */

        td {
            /* More vertical and horizontal spacing */
            padding: 18px 20px;

            border-bottom: 1px solid #163b49;

            font-size: 14px;

            color: #d8f5fa;
        }

        /* More space between rows */
        tbody tr {
            transition: 0.25s ease;
        }

        /* Neon hover effect */
        tbody tr:hover {
            background: #0d3342;

            box-shadow:
                inset 4px 0 0 #00eaff;

            transform: translateX(3px);
        }

        /* Remove border from last row */
        tbody tr:last-child td {
            border-bottom: none;
        }


        /* =================================
           SPECIAL TEXT
           ================================= */

        /* ID styling */
        .id {
            color: #00eaff;

            font-weight: 700;

            text-shadow:
                0 0 6px rgba(0, 234, 255, 0.7);
        }

        /* Username styling */
        .username {
            color: #28f5c4;

            font-weight: 600;

            text-shadow:
                0 0 6px rgba(40, 245, 196, 0.6);
        }

        /* No users message */
        .empty {
            text-align: center;

            padding: 40px;

            color: #78aebc;

            letter-spacing: 1px;
        }


        /* =================================
           MOBILE RESPONSIVE DESIGN
           ================================= */

        @media (max-width: 600px) {

            body {
                /* Smaller spacing on phones */
                padding: 35px 15px;
            }

            .header {
                margin-bottom: 25px;
            }

            .header h1 {
                font-size: 27px;
            }

            .card {
                padding: 18px;
            }

            th,
            td {
                /* Comfortable spacing on small screens */
                padding: 14px 12px;

                font-size: 13px;
            }
        }

    </style>
</head>

<body>

    <div class="container">

        <!-- =================================
             PAGE HEADER
             ================================= -->

        <div class="header">

            <!-- Neon ocean icon -->
            <h1>
                <span class="wave">🌊</span>
                Users
            </h1>

            <!-- Page description -->
            <p>User Management Module</p>

        </div>


        <!-- =================================
             USER TABLE
             ================================= -->

        <div class="card">

            <div class="table-wrapper">

                <table>

                    <!-- Table headings -->
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Username</th>
                        </tr>
                    </thead>


                    <tbody>

                        <?php if (!empty($users)) : ?>

                            <!-- Display each user -->
                            <?php foreach ($users as $user) : ?>

                                <tr>

                                    <!-- User ID -->
                                    <td class="id">
                                        <?= htmlspecialchars($user->id ?? $user['id']) ?>
                                    </td>

                                    <!-- First name -->
                                    <td>
                                        <?= htmlspecialchars($user->firstname ?? $user['firstname']) ?>
                                    </td>

                                    <!-- Last name -->
                                    <td>
                                        <?= htmlspecialchars($user->lastname ?? $user['lastname']) ?>
                                    </td>

                                    <!-- Email -->
                                    <td>
                                        <?= htmlspecialchars($user->email ?? $user['email']) ?>
                                    </td>

                                    <!-- Username -->
                                    <td class="username">
                                        <?= htmlspecialchars($user->username ?? $user['username']) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else : ?>

                            <!-- Displayed when there are no users -->
                            <tr>
                                <td colspan="5" class="empty">
                                    No users found.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

                <form method="post" action="/users">
                    <button type="submit">Add User</button>

            </div>

        </div>

    </div>

</body>
</html>