Universal configuration data loader
=============

This library lets you recursively load configuration data from JSON, YAML and similar files.

* It outputs a single data array with all of your configuration data
* It allows users to split their configuration data into multiple files that can be included.
* Includes keep track of their original files, so relative paths are relative to the file that defines them.
* JSON files can include YAML files and visa-versa

## Usage

Refer to examples/example.php for a clear example of this library's usage