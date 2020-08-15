import moment from 'moment'

const formatNow = {}

formatNow.install = (Vue) => {
    // Declaramos un metodo,y extendemos comportamiento de otros objetos (prototype)
    Vue.prototype.$formatNow = function (date, locale) {
        return moment(date, 'YYYY-MM-DD hh:mm:ss').locale(locale).fromNow();
    }
}

export default formatNow