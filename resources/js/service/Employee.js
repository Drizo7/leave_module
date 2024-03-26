export const CustomerService = {
    getData() {
        return [
            {
                id: 1499,
                name: '1',
                country: {
                    name: 'Adrian Kadya',
                    code: 'ar'
                },
                company: 'Information Technology',
                date: '2023-04-23',
                status: 'pending',
                verified: true,
                activity: 42,
                representative: {
                    name: 'Developer',
                    image: 'amyelsner.png'
                },
                balance: 88090
            },
            {
                id: 1499,
                name: '12',
                country: {
                    name: 'Stephen Chuka',
                    code: 'ar'
                },
                company: 'Information Technology',
                date: '2022-04-23',
                status: 'pending',
                verified: true,
                activity: 42,
                representative: {
                    name: 'Cleaner',
                    image: 'amyelsner.png'
                },
                balance: 5090
            },
            {
                id: 1499,
                name: '13',
                country: {
                    name: 'Raphel Kazembe',
                    code: 'ar'
                },
                company: 'Information Technology',
                date: '2023-04-21',
                status: 'pending',
                verified: true,
                activity: 42,
                representative: {
                    name: 'Guard',
                    image: 'amyelsner.png'
                },
                balance: 8090
            },
            {
                id: 1499,
                name: '5',
                country: {
                    name: 'Abel Tchongwe',
                    code: 'ar'
                },
                company: 'Information Technology',
                date: '2023-01-23',
                status: 'pending',
                verified: true,
                activity: 42,
                representative: {
                    name: 'Marketer',
                    image: 'amyelsner.png'
                },
                balance: 68090
            },
            {
                id: 1499,
                name: '14',
                country: {
                    name: 'Jimmy Phiri',
                    code: 'ar'
                },
                company: 'Information Technology',
                date: '2023-04-23',
                status: 'pending',
                verified: true,
                activity: 42,
                representative: {
                    name: 'Accountant',
                    image: 'amyelsner.png'
                },
                balance: 28090
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
