function drawLegend(canvasId,fillColor,borderColor){
        var canvas = document.getElementById(canvasId);
    var context = canvas.getContext('2d');

    context.beginPath();
    context.rect(10, 10, 10, 10);
    context.fillStyle = fillColor;
    context.fill();
    context.lineWidth = 3;
    context.strokeStyle = borderColor;
    context.stroke();
}
