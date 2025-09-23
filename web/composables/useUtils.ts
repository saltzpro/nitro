export function useUtils() {
    
    function numberFormat(val: any) {

        return new Intl.NumberFormat('en-EN', {
            style: 'decimal',
            currency: 'PHP',
        }).format(val)
    }

    function currencyFormat(val: any) {
        return new Intl.NumberFormat('en-EN', {
            style: 'decimal',
            currency: 'PHP',
            minimumFractionDigits: 2,
        }).format(val)
    }

    return {
        numberFormat, currencyFormat
    }
}