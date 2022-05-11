window.chart = {
    data: [],
    selector_svg: "#svg1",
    selector_chart_box: "#chart_box",
    offset_bottom: 20,
    max_height: 300,
    max_data: 0,
    w: 7,
    ids:[],
    month: 1,
    year: 2022,
    set: function(data){
        var _this = this;
        _this.data = data;
        _this.max_data = Math.max(...data);
    },
    getMonth: function(month){
        var arr_months = ['Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря'];
        return arr_months[month];
    },
    drawItem: function(n, val){
        var _this = this;
        var height_step = (this.max_height - this.max_height/5)/this.max_data;
        var h, x1, y1;
        if(!val){
            h = 1;
            y1 = this.max_height - this.offset_bottom;
        }else{
            h = val*height_step + height_step;
            y1 = this.max_height - h - this.offset_bottom;
        }
        
        var x1 = this.w + n*this.w + (n-1)*this.w;

        var rect = d3.select(this.selector_svg).append("rect")
                    .attr("x", x1)
                    .attr("y", y1)
                    .attr("width", this.w)
                    .attr("height", h)
                    .attr("style", "fill:#0d6efd")
                    .attr("param-title",`Заявки от ${n} ${this.getMonth(this.month)} ${this.year}`)
                    .attr("param-value",`Всего заявок ${val}`)
                    .attr("class", "chart-rect")
                    .on("mouseover", function(d){
                        var title = $(this).attr("param-title");
                        var value = $(this).attr("param-value");
                        _this.drawBox(d.clientX, d.clientY, title, value);
                    })
                    .on("mouseout", function(d){
                        _this.removeBox();
                    });
        var txt = d3.select(this.selector_svg).append("text")
            .attr("x", x1 + (this.w/2))
            .attr("y", this.max_height-15)
            .attr("fill", "#fff")
            .attr("font-size", 7)
            .attr("style","writing-mode: tb;")
            .text(n);
    },
    draw: function(){
        var _this = this;
        d3.select(this.selector_svg).selectAll("*").remove();
        this.data.forEach((item, index) => {
            _this.drawItem(index + 1, item);
        });
    },
    removeBox: function(){
        $(this.selector_chart_box).css("display", "none");
    },
    drawBox: function(x,y,title,value){
        $(this.selector_chart_box).css("left", x);
        $(this.selector_chart_box).css("top", y);
        $(this.selector_chart_box).css("display", "block");
        $(this.selector_chart_box).find(".title").html(title);
        $(this.selector_chart_box).find(".body").html(value);
    }
}