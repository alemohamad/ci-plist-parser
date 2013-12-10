# CodeIgniter Library: Plist Parser

**ci-plist-parser**

## About this library

This CodeIgniter's Library is used to parse a plist configuration file and returns the config as an array. It's very easy to use and very effective.  
Plist is just a more strict form of XML. The only difference is that there are key-value pairs with seperate tags and the value have their types.  

Its usage is recommended for CodeIgniter 2 or greater.  

## Usage

```php
$this->load->library('PlistParser');
$this->plistparser->loadFile('sample.plist');
$configuration = $this->plistparser->getConfig();
print_r($configuration);
```

### sample.plist

```plist
<?xml version="1.0"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
    <dict>
        <key>test1</key>
        <dict>
            <key>test_integer</key>
            <integer>42</integer>
            <key>test_string</key>
            <string>hello!</string>
            <key>test_array</key>
            <array>
                <string>content1</string>
                <string>content2</string>
            </array>
            <key>test_boolean1</key>
            <true />
            <key>test_boolean2</key>
            <boolean>true</boolean>
        </dict>
    </dict>
</plist>
```

### Sample output

```
Array (
    [&dict] => 
    [test1] => Array (
        [&dict] => 
        [test_integer] => 42
        [test_string] => hello!
        [test_array] => Array (
            [0] => content1
            [1] => content2
        )
        [test_boolean1] => 1
        [test_boolean2] => 1
    )
)
```

![Ale Mohamad](http://codeigniter.alemohamad.com/images/logo2012am.png)
