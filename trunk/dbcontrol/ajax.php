<html>
    <body>
        <script type="text/javascript">
            function ajaxFunction(path,id,back)
            {
                var xmlHttp;
                try {
                    // Firefox, Opera 8.0+, Safari
                    xmlHttp=new XMLHttpRequest();
                } catch (e) {
                    // Internet Explorer
                    try {
                        xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e) {
                        try  {
                            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (e) {
                            alert("您的浏览器不支持AJAX！");
                            return false;
                        }
                    }
                }
                xmlHttp.onreadystatechange= function() {
                    if(xmlHttp.readyState==4) {
                        document.getElementById('pre').innerHTML+=xmlHttp.responseText;
                        if (xmlHttp.responseText == "failed<br />") { 
                            document.getElementById(id).parentNode.parentNode.parentNode.style.backgroundColor = '#FF0000';
                        } else {
                            document.getElementById(id).parentNode.parentNode.parentNode.style.backgroundColor = '#00FF00';
                        }
                    }
                }
                xmlHttp.open("POST","fileupload.php",true);
                xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                xmlHttp.send('&path='+path+'&id='+id+'&backup='+back);
            }
            function ajax() {
                document.getElementById('pre').innerHTML = '';
                back = document.getElementById('backup').checked;
                cb = document.getElementsByName('checkbox');
                path = document.getElementById('localpath').value;
                for (i=0;i<cb.length;i++) {
                    if (cb[i].checked == true) {
                        ajaxFunction(path,cb[i].id,back);
                        document.getElementById('pre').innerHTML += 'start';
                    }
                }
            }
        </script>
        <pre id ="pre"></pre>
        <br />
        <input type="input" id="localpath" value="" /><br />
        上传前备份老文件<input type="checkbox" id="backup" /><br />
        <input id="start" type="button" onclick="ajax()" value="开始" />
        <?php
        include './DB.php';
        include './sftp.php';
        $id=$_POST['id'];
        $localPath = trim($_POST['localpath']);

        $db = new DB('61.160.192.2', 'xj', 'z;fs6pjahsuu^5o8', 'xj_admin');
        $queryString = "SELECT `id`,`domain`,`platform_name`,`server_number`,`server_name` FROM `server_config` ORDER BY domain";
        $info = $db->selectAsArray($queryString);
        echo "<table>";
        foreach ($info as $each) {
            echo "<tr>";
            echo "<label for=\"{$each['id']}\">";
            echo "<td><input type=\"checkbox\" name=\"checkbox\" onclick=\"parentNode.style.backgroundColor = this.checked==true ? '0000FF' : ''\" id=\"{$each['id']}\"/></td>";
            echo "<td>{$each['platform_name']}</td>";
            echo "<td>{$each['server_number']}</td>";
            echo "<td>{$each['server_name']}</td>";
            echo "<td>{$each['domain']}</td>";
            echo "</label>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </body>
</html>
