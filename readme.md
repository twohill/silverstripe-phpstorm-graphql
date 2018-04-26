# SilverStripe-PhpStorm-GraphQL helper

This module allows you to use [JS GraphQL](https://github.com/jimkyndemeyer/js-graphql-intellij-plugin) within your SilverStripe
project.

It does this by providing another authenticator that lets JS GraphQL query the schema without logging in. 
There might be a better way of going about this - I'm all ears!

To provide some sort of security, by default we restrict to queries from localhost, with the user-agent "JS GraphQL",
and only in dev mode.

## Requirements
 * silverstripe-graphql
 * PhpStorm
 * JS GraphQL

## Installation
Install the JS GraphQL plugin
Install this helper
```
composer require twohill/silverstripe-phpstorm-graphql
```

Create a `graphql.config.json` with the following details (update the URL as required)
```json
{
  "schema": {
    "request": {
      "url": "http://localhost/graphql",
      "method": "POST",
      "postIntrospectionQuery": true,
      "options": {
        "headers": {
          "user-agent": "JS GraphQL",
          "Origin": "localhost"
        }
      }
    }
  },
  "endpoints": [
    {
      "name": "Default (http://localhost/graphql)",
      "url": "http://localhost/graphql",
      "options": {
        "headers": {
          "user-agent": "JS GraphQL",
          "Origin": "localhost"
        }
      }
    }
  ]
}
```

Edit some GraphQL and see some lovely schema completion :)


## License
See [License](license.md)


## Example configuration (optional)
If you want to override any of the security settings you can do so via yaml.


```yaml

Twohill\PhpStormGraphQL\PhpStormDevAuthenticator:
  allowed_ips:
    - '127.0.0.1'
  allowed_useragent: 'JS GraphQL'
  allowed_environment: 'dev'
```

## Maintainers
 * Al Twohill (alt) <al@twohill.nz>
 
## Bugtracker
Bugs are tracked in the issues section of this repository. Before submitting an issue please read over 
existing issues to ensure yours is unique. 
 
If the issue does look like a new bug:
 
 - Create a new issue
 - Describe the steps required to reproduce your issue, and the expected outcome. Unit tests, screenshots 
 and screencasts can help here.
 - Describe your environment as detailed as possible: SilverStripe version, Browser, PHP version, 
 Operating System, any installed SilverStripe modules.
 
Please report security issues to the module maintainers directly. Please don't file security issues in the bugtracker.
 
## Development and contribution
If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.
