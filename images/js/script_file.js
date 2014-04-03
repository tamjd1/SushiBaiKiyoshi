function menu_list(id)
{
var y = document.getElementById(id).style.color;
var x = document.getElementById(id + "_list").style.display;

if (x == "table" || x == "")
{
    document.getElementById(id + "_list").style.display="none";
    document.getElementById(id).style.color="blue";
}
else
{
    document.getElementById(id + "_list").style.display="table";
}


}