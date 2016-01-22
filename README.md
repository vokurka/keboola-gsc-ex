# Documentation

The Google Search Console Extractor for Keboola Connection Platform now only supports downloading data about URL Crawl Errors. For more features write an e-mail to kurka.vojtech@gmail.com.

To use Google Search Console Extractor you just need to create the component in your KBC project and set the configuration correctly. Also, there is some API and credentials setting.

1. You need to enable Google Search Console API here: https://console.developers.google.com/apis/library
2. You need to create new credentials here: https://console.developers.google.com/apis/credentials - go to New credentials > Server Key > As a Key type choose JSON > Create. A JSON file will be downloaded to your computer - open it in text editor, it contains all the info you need for logging in.
3. You need to add permissions for newly created Service Account in Google Search Console - add the client_email from JSON file as a new user to your Google Search Console.
4. Profit.

Here is an example of configuration:

```
{
	"bucket": "in.c-ex-gsc-main",
    "client_id": "<your_client_id_here>",
    "client_email": "<your_client_email_here>"
    "private_key": "<your_private_key_here>"
    "site_url": "<your_site_url_here>"
}
```

* bucket - destination bucket for downloaded data
* client_id - username of account you are using to access Zuora
* client_email - password of account you are using to access Zuora
* private_key - placeholder for use in queries so you do not have to type the date again in every query
* site_url - placeholder for use in queries so you do not have to type the date again in every query

Now you are ready to go!