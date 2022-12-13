<!doctype html>
<html>
<head>
<title>Seguimiento de estados SIGMA</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<style>
    .cuadrado{
        width: 30px;
        height: 30px;
    }
    .recta{
        margin-left: 12px;/* width_cuadrado/2 - width_recta/2 */
        height: 100px;
        width: 6px;
    }
    .cuadrado, .recta{
        background-color: green;
    }
    .icono{
        font-size: 20px;
        font-weight: bold;
        margin-left: 5px;
        margin-top: 5px;
        color: white;
    }
    .texto-etapa{
        display: inline-block;
        position: relative; 
        top: 15px;
        width: 400px; 
        font-weight: 600;
        font-size: 17px;
        font-family: "Segoe UI",Arial,sans-serif;
    }

    .global-container{
        margin-left: 10%;
    }
    .cont-text-check1{
        position:relative;
        bottom: 34px;
    }

    .cont-text-check2{
        position:relative;
        bottom: 48px;
    }
    
    .cont-text-check3{
        position:relative;
        bottom: 82px;
    }

    .cont-text-check4{
        position:relative;
        bottom: 115px;
    }

    .cont-text-check5{
        position:relative;
        bottom: 150px;
    }
    @media (min-width: 250px){
        .global-container{
            margin-left: 15%;
        }

        .texto-etapa{
            display: inline-block;
            position: relative; 
            top: 15px;
            width: 200px; 
            font-weight: 600;
            font-size: 15px;
            font-family: "Segoe UI",Arial,sans-serif;
        }
    }
    @media (min-width: 500px){
        .global-container{
            margin-left: 20%;
        }

        .texto-etapa{
            display: inline-block;
            position: relative; 
            top: 15px;
            width: 300px; 
            font-weight: 600;
            font-size: 17px;
            font-family: "Segoe UI",Arial,sans-serif;
        }
        
        .cont-text-check1{
            position:relative;
            bottom: 30px/*34*/;
        }

        .cont-text-check2{
            position:relative;
            bottom: 60px;/*48*/
        }
        
        .cont-text-check3{
            position:relative;
            bottom: 102px;/*81*/
        }

        .cont-text-check4{
            position:relative;
            bottom: 120px;/*115*/
        }

        .cont-text-check5{
            position:relative;
            bottom: 150px;/*148*/
        }
    }
    @media (min-width: 1000px){
        .global-container{
            margin-left: 30%;
        }

        .texto-etapa{
            display: inline-block;
            position: relative; 
            top: 15px;
            width: 400px; 
            font-weight: 600;
            font-size: 17px;
            font-family: "Segoe UI",Arial,sans-serif;
        }

        .cont-text-check1{
            position:relative;
            bottom: 30px/*34*/;
        }

        .cont-text-check2{
            position:relative;
            bottom: 60px;/*48*/
        }
        
        .cont-text-check3{
            position:relative;
            bottom: 90px;/*81*/
        }

        .cont-text-check4{
            position:relative;
            bottom: 120px;/*115*/
        }

        .cont-text-check5{
            position:relative;
            bottom: 150px;/*148*/
        }
    }

    @media (min-width: 1300px){
        .global-container{
            margin-left: 38%;
        }
    }
</style>
</head>
<body>
    <div class="global-container">
    <div>
        <div style="display: inline-block;">
            <div class="cuadrado"><span class="icono">&#10003;</span></div>
            <div class="recta"></div>
        </div>
        <div class="texto-etapa">Se registró el ingreso de tu unidad el dia 20/01/20 a las 12:35 am</div>
    </div>
    <div class="cont-text-check1">
        <div style="display: inline-block;">
            <div class="cuadrado"><span class="icono">&#10003;</span></div>
            <div class="recta"></div>
        </div>
        <div class="texto-etapa">Tu vehículo fue aprobado por el seguro el día 29/01/20 a las 05:30 pm</div>
    </div>
    <div class="cont-text-check2">
        <div style="display: inline-block;">
            <div class="cuadrado"><span class="icono">&#10003;</span></div>
            <div class="recta"></div>
        </div>
        <div class="texto-etapa">Se registró tu aprobación el día 29/01/20 a las 06:30 pm</div>
    </div>
    <div class="cont-text-check3">
        <div style="display: inline-block;">
            <div class="cuadrado"><span class="icono">&#10003;</span></div>
            <div class="recta"></div>
        </div>
        <div class="texto-etapa">Tu vehículo inició el proceso de reparación el día 30/01/20 a las 10:00 am</div>
    </div>
    <div class="cont-text-check4">
        <div style="display: inline-block;">
            <div class="cuadrado"><span class="icono">&#10003;</span></div>
            <div class="recta"></div>
        </div>
        <div class="texto-etapa">Tu vehículo se encuentra listo.  Pronto nos estaremos comunicando contigo.</div>
    </div>
    <div class="cont-text-check5">
        <div style="display: inline-block;">
            <div class="cuadrado"><span class="icono">&#10003;</span></div>
        </div>
        <div class="texto-etapa">Se registró la entrega de tu unidad el día 02/02/20 a las 10:00 am</div>
    </div>
    </div>
</body>