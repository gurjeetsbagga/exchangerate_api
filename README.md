# Exchange Rates

Prepare a web widget, using a modern Javascript framework, showing current exchange 
rates of a few well known currencies e.g. USD, EUR, CHF, AUD, CAD to GBP.

- Backend - Phalcon 4.0.5 as PHP framework
- Frontend - Vue JS + Tailwind CSS

## Installation

### Prerequisite System should have Docker & git

First clone this respository from github with below command

### Install Project - Clone Git repository

Clone the repository somewhere with below command.

`git clone git@github.com:gurjeetsbagga/exchangerate_api.git exchange_rate`

Go to cloned folder

`cd exchange_rate`

### Change permission to start.sh file

Change permission to start.sh file

`chmod +x ./start.sh`

## Run project

Run start.sh file, which deploy and build container

`chmod +x ./start.sh`

## Sample output of API for USD

```
{
  "base_code": "USD",
   "currency_rates": {
      "USD": 1.015176,
      "EUR": 1,
      "GBP": 0.875077,
      "CHF": 0.973523,
      "CAD": 1.323388,
      "AUD": 1.482209,
      "JPY": 144.667762,
      "CNY": 7.031624,
      "RUB": 61.707607,
      "IRR": 43043.482408,
      "AED": 3.728849,
      "TRY": 18.513168,
      "IQD": 1482.157637,
      "INR": 80.864948
  },
  "symbols": {
    "USD": "United States Dollar",
    "EUR": "Euro",
    "GBP": "British Pound Sterling",
    "CHF": "Swiss Franc",
    "CAD": "Canadian Dollar",
    "AUD": "Australian Dollar",
    "JPY": "Japanese Yen",
    "CNY": "Chinese Yuan",
    "RUB": "Russian Ruble",
    "IRR": "Iranian Rial",
    "AED": "United Arab Emirates Dirham",
    "TRY": "Turkish Lira",
    "IQD": "Iraqi Dinar",
    "INR": "Indian Rupee"
  }
}
```