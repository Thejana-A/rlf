<link rel="stylesheet" type="text/css" href="../css/merchandiser/calendar.css" />


<script>
    function getNumberOfDaysInMonth(year, month) {
        return new Date(year, month, 0).getDate();
    } 
    const date = new Date();
    var calendar = "";
    var currentYear = date.getFullYear();
    var currentMonth = date.getMonth();
    const firstOfThisMonth = new Date(currentYear+"-"+(currentMonth+1)+"-"+01);
    var dayOfFirstThisMonth = firstOfThisMonth.getDay();
    var numberOfDate = 1;
    var multiplicationFactor = 0;
    var numberOfDaysInMonth = getNumberOfDaysInMonth(currentYear, (currentMonth+1));
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    
    calendar += "<table border='1'>"; 
    calendar += "<tr><td colspan='7' style='background-color:#FFA500;'><center><b>"+currentYear+"</b></center></td></tr>";
    calendar += "<tr><td colspan='7' style='background-color:#cccccc;'><center><b>"+months[currentMonth]+"</b></center></td></tr>";
    calendar += "<tr class='nameOfDay'><td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td></tr>";
    switch(dayOfFirstThisMonth){
        case 0: 
            while(numberOfDate < numberOfDaysInMonth){
                calendar += "<tr>";
                while(numberOfDate <= 7+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            calendar += "<td>"+numberOfDate+"</td>";
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
        case 1: 
            while(numberOfDate < numberOfDaysInMonth){
                if(multiplicationFactor == 0){
                    calendar += "<tr><td></td>";
                }else{
                    calendar += "<tr>";
                }
                while(numberOfDate <= 6+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            calendar += "<td>"+numberOfDate+"</td>";
                            
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
        case 2: 
            while(numberOfDate < numberOfDaysInMonth){
                if(multiplicationFactor == 0){
                    calendar += "<tr><td></td><td></td>";
                }else{
                    calendar += "<tr>";
                }
                while(numberOfDate <= 5+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            calendar += "<td>"+numberOfDate+"</td>";
                            
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
        case 3: 
            while(numberOfDate < numberOfDaysInMonth){
                if(multiplicationFactor == 0){
                    calendar += "<tr><td></td><td></td><td></td>";
                }else{
                    calendar += "<tr>";
                }
                while(numberOfDate <= 4+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            calendar += "<td>"+numberOfDate+"</td>";
                            
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
        case 4: 
            while(numberOfDate < numberOfDaysInMonth){
                if(multiplicationFactor == 0){
                    calendar += "<tr><td></td><td></td><td></td><td></td>";
                }else{
                    calendar += "<tr>";
                }
                while(numberOfDate <= 3+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            calendar += "<td>"+numberOfDate+"</td>";
                            
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
        case 5: 
            while(numberOfDate < numberOfDaysInMonth){
                if(multiplicationFactor == 0){
                    calendar += "<tr><td></td><td></td><td></td><td></td><td></td>";
                }else{
                    calendar += "<tr>";
                }
                while(numberOfDate <= 2+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            
                            calendar += "<td>"+numberOfDate+"</td>";
                            
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
        case 6: 
            while(numberOfDate <= numberOfDaysInMonth){
                if(multiplicationFactor == 0){
                    calendar += "<tr><td></td><td></td><td></td><td></td><td></td><td></td>";
                }else{
                    calendar += "<tr>";
                }
                while(numberOfDate <= 1+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            
                            calendar += "<td>"+numberOfDate+"</td>";
                            
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
    }
            

    calendar += "</table>";
    document.write(calendar);
    
</script>


    

