/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function validationCheck()
{
    var agefrom = document.forms["searchForm"]["ageFrom"].value;
    var ageto = document.forms["searchForm"]["ageTo"].value;
    var err = document.getElementById("errorMassage");
    //alert(agefrom+ageto);
    if (!isNaN(agefrom) && !isNaN(ageto))
    {
        if (agefrom == "" && ageto == "")
        {
            err.innerHTML = "Age canot be blank ";
            err.style.color = "red";
            return false;
        }
        else
        {
            if (agefrom >= ageto)
            {

                err.innerHTML = "Age \"from\" should be greater than \" to\" ";
                err.style.color = "red";
                return false;
            }
            else
            {
                if (agefrom < ageto)
                {
                    alert(agefrom + "  " + ageto);
                    return true;
                }
            }

        }
    }
    else
    {
        err.innerHTML = "Age cannot be blank and should be Numeric number";
        err.style.color = "red";
        return false;
    }
}

