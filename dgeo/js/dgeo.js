function grafico_barra(id_div, titulo, yAxitit, linhas=[['Jan', 1, 2, 3], ['Fev', 3, 5, 4], ['Mar', 3, 4, 1]], headers=['#', 'Hidro', 'Plan', 'CobTer']){
    anychart.onDocumentReady(function () {
        // create data set on our data
        var chartData = {
            title: titulo, //'Top 3 Products with Region Sales Data',
            header: headers, //['#', 'Hidro', 'Plan', 'CobTer'],
            rows: linhas //[['Jan', 6814, 3054, 4376], ['Fev', 7012, 5067, 8987], ['Mar', 8814, 9054, 4376]]
        };
        // create column chart
        var chart = anychart.column();
        // set chart data
        chart.data(chartData);
        // turn on chart animation
        chart.animation(true);
        chart.yAxis().labels().format('{%Value}{groupsSeparator: }');
        // set titles for Y-axis
        chart.yAxis().title(yAxitit);
        chart
            .labels()
            .enabled(true)
            .position('center-top')
            .anchor('center-bottom')
            .format('{%Value}{groupsSeparator: }');
        chart.hovered().labels(false);
        // turn on legend and tune it
        chart.legend().enabled(true).fontSize(16).padding([0, 0, 0]);
        // interactivity settings and tooltip position
        chart.interactivity().hoverMode('single');
        chart
            .tooltip()
            .positionMode('point')
            .position('center-top')
            .anchor('center-bottom')
            .offsetX(0)
            .offsetY(5)
            .titleFormat('{%X}')
            .format('{%SeriesName} : {%Value}{groupsSeparator: }');
        // set container id for the chart
        chart.container(id_div);
        // initiate chart drawing
        chart.draw();
    });
}

function grafico_circular(container, titulo, names, data, espessura=22, sombra=true, posicao=40, ang=285){

    if(sombra) data.push(100);
    console.log(data);
    $k = data.length - 1;
    var dataSet = anychart.data.set(data);
    var palette = anychart.palettes
        .distinctColors()
        .items([
            '#64b5f6',
            '#1976d2',
            '#ef6c00',
            '#ffd54f',
            '#455a64',
            '#96a6a6',
            '#dd2c00',
            '#00838f',
            '#00bfa5',
            '#ffa000'
        ]);
  
    var makeBarWithBar = function (gauge, radius, i, width) {
        var stroke = null;
        gauge
            .label(i)
            .text(names[i] + ', <span style="">' + data[i] + '%</span>') // color: #7c868e
            .useHtml(true);
        gauge
            .label(i)
            .hAlign('center')
            .vAlign('middle')
            .anchor('right-center')
            .padding(0, 10)
            .height(width / 2 + '%')
            .offsetY(radius + '%')
            .offsetX(0);

        gauge
            .bar(i)
            .dataIndex(i)
            .radius(radius)
            .width(width)
            .fill(palette.itemAt(i))
            .stroke(null)
            .zIndex(5);
        gauge
            .bar(i + 100)
            .dataIndex($k)
            .radius(radius)
            .width(width)
            .fill('#F5F4F4')
            .stroke(stroke)
            .zIndex(4);

        return gauge.bar(i);
    };
  
    anychart.onDocumentReady(function () {
        var gauge = anychart.gauges.circular();
        gauge.data(dataSet);
        gauge
          .fill('#fff')
          .stroke(null)
          .padding(0)
          .margin(100)
          .startAngle(0)
          .sweepAngle(ang);
  
        var axis = gauge.axis().radius(100).width(1).fill(null);
        axis
          .scale()
          .minimum(0)
          .maximum(100)
          .ticks({ interval: 1 })
          .minorTicks({ interval: 1 });
        axis.labels().enabled(false);
        axis.ticks().enabled(false);
        axis.minorTicks().enabled(false);

        for($j=0; $j < $k; $j++) makeBarWithBar(gauge, posicao + ($j * (espessura + 2)), $j, espessura);
    
        gauge.margin(10);
        gauge
            .title()
            .text(titulo)
            .useHtml(true);
        gauge
            .title()
            .enabled(true)
            .hAlign('center')
            .padding(0)
            .margin([0, 0, 0, 0]);
  
        gauge.container(container);
        gauge.draw();
    });
}

function grafico_bateria(container, percentual, titulo, desc_titulo, color=true){
    anychart.onDocumentReady(function () {
        // Helper function to create gauge
        function createGaugeBase() {
            // Create gauge
            var gauge = anychart.gauges.linear();
            gauge
                .layout('horizontal')
                .background({ stroke: '10 #545f69', fill: '#ffffff' })
                .margin([30, 45, 30, 30])
                .padding(0);
      
            // Set gauge tooltip
            gauge.tooltip().useHtml(true).format('Value: {%Value}%');
        
            // Create label to make gauge look like battery
            var label = gauge.label();
            label
                .text(null)
                .position('right-center')
                .anchor('right-center')
                .width(20)
                .height('30%')
                .offsetX('20px')
                .background({ enabled: true, fill: '#545f69' });
        
            // Set axis scale
            var scale = gauge.scale();
            scale.minimum(0).maximum(100).ticks({ interval: 10 });
            return gauge;
        }
      
        function batteryBar(value) {
            // Create gauge
            var gauge = createGaugeBase();
            gauge.data([value]);
    
            // Create bar pointer
            var batteryEnergy = gauge.bar(0);
            batteryEnergy
                .name('Energy')
                .width('90%')
                .offset(0)
                .fill(function () {
                if (gauge.data().get(0, 'value') >= 25) return '#545f69';
                return '#D81F05';
                })
                .stroke(null)
                .zIndex(11);
            return gauge;
        }
      
        function batteryLED(value) {
            // Create gauge
            var gauge = createGaugeBase();
            gauge.data([value]);
      
            // Create LED pointer
            var batteryEnergy = gauge.led(0);
      
            batteryEnergy
                .size(null)
                .name('Energy')
                .width(90)
                .count(10)
                // Set gap
                .gap(1)
                // Color settings
                .dimmer(function () {
                    return '#ffffff';
                });
                
            $cor_padrao = ['#545f69', '#545f69'];
            if( value >= 75 ) batteryEnergy.colorScale().colors(color ? ['#32CD32', '#32CD32'] : $cor_padrao);
            else if( value >= 25 ) batteryEnergy.colorScale().colors($cor_padrao);
            //else if( value >= 25 ) batteryEnergy.colorScale().colors(color ? ['#FFD700', '#FFD700'] : $cor_padrao);
            else batteryEnergy.colorScale().colors(color ? ['#D81F05', '#D81F05'] : $cor_padrao);
      
            return gauge;
        }
      
        // Create layout table and set some settings
        var layoutTable = anychart.standalones.table();
        layoutTable
            .hAlign('center')
            .vAlign('middle')
            .useHtml(true)
            .fontSize(16)
            .cellBorder(null);
      
        // Put gauges into the layout table
        layoutTable.contents([
            /*['Battery', null],
            [
                'Gauge with Bar Pointer<br>' +
                '<span style="color: #212121; font-size: 12px">Charged 5%</span>',
                'Gauge with Bar Pointer<br>' +
                '<span style="color: #212121; font-size: 12px">Charged 75 %</span>'
            ],
            [batteryBar(5), batteryBar(75)],
            [
                'Gauge with LED Pointer<br>' +
                '<span style="color: #212121; font-size: 12px">Charged 20%</span>',
                'Gauge with LED Pointer<br>' +
                '<span style="color: #212121; font-size: 12px">Charged 100%</span>'
            ],
            [batteryLED(20), batteryLED(100)]*/
            [titulo],
            [desc_titulo],
            [batteryLED(percentual)],
            []
        ]);
      
        // Set height for first row in layout table
        layoutTable.getRow(0).height(40).fontSize(18);
        layoutTable.getRow(1).height(50);
        layoutTable.getRow(3).height(50);
      
        // Merge cells in layout table where needed
        layoutTable.getCell(0, 0).colSpan(2);
      
        // Set container id and initiate drawing
        layoutTable.container(container);
        layoutTable.draw();
    });
}