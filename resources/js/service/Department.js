export const CustomerService = {
    getData() {
        return [
            {
                id: 1499,
                name: '29',
                country: {
                    name: 'Information Technology',
                    code: 'ar'
                },
                company: 'Affiliated With Travelodge',
                date: '2015-04-23',
                status: 'renewal',
                verified: true,
                activity: 42,
                representative: {
                    name: 'IT',
                    image: 'amyelsner.png'
                },
                balance: 88090
            },{
                id: 1499,
                name: '19',
                country: {
                    name: 'Accounting',
                    code: 'ar'
                },
                company: 'Affiliated With Travelodge',
                date: '2015-04-23',
                status: 'renewal',
                verified: true,
                activity: 42,
                representative: {
                    name: 'AC',
                    image: 'amyelsner.png'
                },
                balance: 88090
            },
            {
                id: 1499,
                name: '23',
                country: {
                    name: 'Sales and Marketing',
                    code: 'ar'
                },
                company: 'Affiliated With Travelodge',
                date: '2015-04-23',
                status: 'renewal',
                verified: true,
                activity: 42,
                representative: {
                    name: 'SM',
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
