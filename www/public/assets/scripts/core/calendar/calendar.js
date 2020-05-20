class Calendar {

    constructor(target, events) {
        this.getConstant()
        this.eventsArray = {'8': "event"}
        this.target = $(target)
        this.month = moment();
    }

    createEvent() {

    }

    selectDay(e) {
        if (e.target.classList.contains("event")) {
            return;
        }
        
        e.target.classList.add("select-day")
    }

    getDayOfWeek() {
        let days = {}
        for (let i = 1; i <= 7; i++) {
            days[moment(this.month).weekday(i).format("dddd")] = i
        }

        return days;
    }


    getStructureWeek = () => {
        let week = {};
        let nbWeeks = 1;
        week[nbWeeks] = {};
        for (let i = 1; i <= Object.keys(this.dayOfMonth).length; i++) {
            if (this.dayOfMonth[i] % 7 === 1) {
                nbWeeks++;
                week[nbWeeks] = {};
            }

            let dateFormat = moment().date(i).month(this.month.format("MM") - 1).year(this.month.format("Y")).format("DD-MM-Y");
            let day = this.createElement("td", i, {"class": "day", "data-date": dateFormat})
            day.addEventListener("click", (e) => {
                this.selectDay(e)
            })
            week[nbWeeks][this.dayOfMonth[i]] = day
        }

        return week
    }

    navigate(goTo) {
        console.log(goTo)
        if (goTo === "prev") {
            this.month = this.month.subtract(1, "months")
        }else if (goTo === "next") {
            this.month = this.month.add(1, "months")
        }else {
            this.month = moment(goTo)
        }
        this.getConstant()
        this.render(this.target)
    }

    currentDay() {
        return moment.format("d-m-Y");
    }

    currentMonth() {
        return moment.format("m-Y");
    }

    currentYear() {
        return moment.format("Y");
    }

    render() {
        this.target.innerHTML = "";
        let lastDay = moment(this.month).endOf("month").format("DD-MM-YYYY");
        let firstDay = moment(this.month).startOf("month").format("DD-MM-YYYY");
        let nbDay = lastDay.split("-").shift()

        this.setDayOfMonth(nbDay);
        let structure = this.getStructureWeek()

        this.renderWeek(structure)
        let table = this.createElement("table", "");

        table.append(this.renderHeader(), this.calendarDays)
        this.target.html(table)
    }

    renderWeek(structure) {
        let headerDays = this.createElement("tr", "", {"class": "row"});
        for (const dayOfWeekKey in this.dayOfWeek) {
            headerDays.append(this.createElement("td", dayOfWeekKey, {"class": "header-day"}))
        }
        this.calendarDays.append(headerDays)
        for (const week in structure) {
            let row = this.createElement("tr", "", {"class": "row"});

            for (const day in structure[week]) {
                let event = ""

                if (this.eventsArray[structure[week][day].innerHTML] != undefined) {
                    event = this.createElement("div", "Event", {"class": "event"})
                    event.addEventListener("click", (e) => {
                        this.selectEvent(e)
                    })
                }

                if(structure[week][day].getAttribute("data-date") == moment().format("DD-MM-Y")){
                    structure[week][day].classList.add("today")
                }
                structure[week][day].append(event)
                row.append(structure[week][day])
            }

            for (let i = 1; i <= 7 - Object.keys(structure[week]).length; i++) {
                if(Object.keys(structure[week]).length > 0){

                if (week == 1) {
                    let day = this.createElement("td", "", {"class": "day is-disable"})
                    row.prepend(day)
                }
                }
            }

            this.calendarDays.append(row)
        }
    }

    createElement(type, content, attributes) {
        let element = document.createElement(type)
        element.append(content)
        for (const attributeKey in attributes) {
            element.setAttribute(attributeKey, attributes[attributeKey])
        }
        return element;
    }

    renderHeader() {
        let left = this.createElement("th", this.createElement("button", "Prev"), {"col-span": 1})
        left.addEventListener("click", (e) => {
            this.navigate("prev")
        })

        let center = this.createElement("th", this.createElement("input", "", {
            "type": "date",
            "value" : moment(this.month).format("Y-MM-DD"),
            "class": "datetime-picker"
        }), {"col-span": 5})
        center.addEventListener("change", (e) => {
            this.navigate(e.target.value)
        })

        let right = this.createElement("th", this.createElement("button", "Next"), {"col-span": 1})
        right.addEventListener("click", (e) => {
            this.navigate("next")
        })
        let headerRow = this.createElement("tr", "", {"class": "calendar-header"})
        let header = this.createElement("thead", "", {"class": "calendar-header"})
        headerRow.append(left, center, right)
        header.append(headerRow)

        return header
    }

    selectEvent(target) {
        console.log(target)
    }

    getConstant() {
        this.dayOfMonth = {};
        this.dayOfWeek = this.getDayOfWeek();
        this.calendarDays = this.createElement("tbody", "", {});
    }

    setDayOfMonth(nbDay) {
        for (let i = 1; i <= nbDay; i++) {
            let day = moment(this.month).date(i).format("dddd")
            this.dayOfMonth[i] = this.dayOfWeek[day]
        }
    }
}