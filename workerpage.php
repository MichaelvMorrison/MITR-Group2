<!DOCTYPE html>
<html lang="en">

<head>
    <title>Worker Portal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include "style.php";?>

</head>

<body>
  <div class="p-5">
    <?php include 'navbar.php';?>
  </div>
    <div class="container">
        <div class="sub-container" style="padding-left:15px; padding-right:15px;">
            <div class="row" style="padding-bottom: 15px;">
                <div class="col-sm-12">
                    <h3>Your Work Schedule</h3>
                </div>
            </div>

            <?php
            $server = 'localhost';
            $user = 'root';
            $pass = '';
            $dbname = 'janrenovation';
            $dbconn = new PDO("mysql:host=$server;dbname=$dbname", $user, $pass);
            $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $starttime = "";
            $endtime = "";


            // var_dump(document);
            $query = $dbconn->prepare('
                SELECT t.uid,t.pid,t.starttime,t.endtime,p.address,p.borough
                FROM `timesheet` t,
                `projects` p
                WHERE
                t.uid=3
                and p.pid = t.pid
                ORDER BY starttime,endtime;'
                );
            $query->execute(array(':starttime'=>$starttime,':endtime'=>$endtime));
            $result = $query->fetchAll();
            // var_dump($result);
            // printf($result[0]["endtime"]);
            $arr= array();
            foreach($result as $value){
                $stime = date("H:i",strtotime($value["starttime"]));
                $dayofweek = date("l",strtotime($value["starttime"]));

                // printf($stime);
                // printf($dayofweek);

            }
            // var_dump($result);
            echo "
            <script>
            $(document).ready(function(){
                var arr = ".json_encode($result).";
                console.log(arr);
                var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
                for(var i=0;i<arr.length;i++){
                    var borough = arr[i]['borough'];
                    var address = arr[i]['address'];
                    var startdate = new Date(arr[i]['starttime']);
                    var enddate = new Date(arr[i]['endtime']);
                    var dayofweek = days[startdate.getDay()];
                    var starttime = startdate.toLocaleTimeString('en-US');
                    var endtime = enddate.toLocaleTimeString('en-US');

                    //If we are including multiple job sites in a day. CreateElement('div') to block off info for one

                    var node = document.createElement('li');
                    var textnode = document.createTextNode(dayofweek);
                    node.appendChild(textnode);
                    document.getElementById(dayofweek).appendChild(node);

                    var node = document.createElement('li');
                    var textnode = document.createTextNode(starttime);
                    node.appendChild(textnode);
                    document.getElementById(dayofweek).appendChild(node);

                    var node = document.createElement('li');
                    var textnode = document.createTextNode(endtime);
                    node.appendChild(textnode);
                    document.getElementById(dayofweek).appendChild(node);

                    var node = document.createElement('li');
                    var textnode = document.createTextNode(address);
                    node.appendChild(textnode);
                    document.getElementById(dayofweek).appendChild(node);

                    var node = document.createElement('li');
                    var textnode = document.createTextNode(borough);
                    node.appendChild(textnode);
                    document.getElementById(dayofweek).appendChild(node);
                }
                console.log(document);
            })

            </script>"

            ?>



            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Monday</th>
                        <th scope="col">Tuesday</th>
                        <th scope="col">Wednesday</th>
                        <th scope="col">Thursday</th>
                        <th scope="col">Friday</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <ul id= "Monday">
                            </ul>
                        </td>
                        <td><ul id= "Tuesday">
                            </ul>
                        </td>
                        <td><ul id= "Wednesday">
                            </ul>
                        </td>
                        <td><ul id= "Thursday">
                            </ul>
                        </td>
                        <td><ul id= "Friday">
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3/12/2019</th>
                        <td>Tuesday</td>
                        <td>9:00 AM</td>
                        <td>5:00 PM</td>
                        <td>256 4th Street</td>
                    </tr>
                    <tr>
                        <th scope="row">3/13/2019</th>
                        <td>Wednesday</td>
                        <td>9:00 AM</td>
                        <td>5:00 PM</td>
                        <td>256 4th Street</td>
                    </tr>
                </tbody>
            </table>


        </div>
    </div>

</body>

</html>