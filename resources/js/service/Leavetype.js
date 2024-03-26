export const CustomerService = {
    getData() {
        return [
            {
                id: 1499,
                name: '1499',
                country: {
                    name: 'Sick Leave',
                    code: 'ar'
                },
                company: 'Leave granted to Sick Employees',
                date: '2019-04-23',
                status: 'renewal',
                verified: true,
                activity: 42,
                representative: {
                    name: 'Leave granted to Sick Employees',
                    image: 'amyelsner.png'
                },
                balance: 88090
            }
        ];
    },

    getCustomersSmall() {
        return Promise.resolve(this.getData().slice(0, 10));
    },

    getCustomersMedium() {
        return Promise.resolve(this.getData().slice(0, 50));
    },

    getCustomersLarge() {
        return Promise.resolve(this.getData().slice(0, 200));
    },

    getCustomersXLarge() {
        return Promise.resolve(this.getData());
    },

    getCustomers(params) {
        const queryParams = params
            ? Object.keys(params)
                  .map((k) => encodeURIComponent(k) + '=' + encodeURIComponent(params[k]))
                  .join('&')
            : '';

        return fetch('https://www.primefaces.org/data/customers?' + queryParams).then((res) => res.json());
    }
};
