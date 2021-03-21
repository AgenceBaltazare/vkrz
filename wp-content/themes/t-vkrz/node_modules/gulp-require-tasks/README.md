# gulp-require-tasks

[![npm version](https://badge.fury.io/js/gulp-require-tasks.svg)](http://badge.fury.io/js/gulp-require-tasks)


This convenient module allows you to load *Gulp* tasks from the
multiple individual files.


## Features

- Loads individual task files recursively from the specified directory
- The name of the task is inferred from the directory structure, e.g. `build:styles:clean`
- Easily integrates into the `gulpfile.js` without breaking your existing tasks
- Gulp instance and task callback are automatically passed to your task function
- Very flexible: almost all aspects of the module is configurable
- Each task is stored in it's own local node module to completely separate concerns


## Installation

### Install library with *npm*

`npm i --save-dev gulp-require-tasks`


## Usage

Create a directory alongside your `gulpfile.js` to store your individual
task modules, e.g. `./tasks`. Place your tasks into this directory.
One task per JavaScript file. Use sub-directories to structure your tasks.

Load tasks from your `gulpfile.js`:

```javascript

// Require the module.
var gulpRequireTasks = require('gulp-require-tasks');

// Call it when neccesary.
gulpRequireTasks({
  // Pass any options to it. Please see below.
  path: __dirname + '/tasks' // This is default
});
```


## Options

| Property     | Default Value     | Description
| ------------ | ----------------- | --------------------------------------------------------
| path         | `./tasks/`        | Path to directory from which to load your tasks
| separator    | `:`               | Task name separator, your tasks would be named, e.g. `foo:bar:baz` for `./tasks/foo/bar/baz.js`
| arguments    | `[]`              | Additional arguments to pass to your task function
| passGulp     | `true`            | Whether to pass Gulp instance as a first argument to your task function
| passCallback | `true`            | Whether to pass task callback function as a last argument to your task function
| gulp         | `require('gulp')` | You could pass your existing Gulp instance if you have one


## Task module format

Consider you have the following task module: `./tasks/build/styles.js`.


### Module as a function

You could define module as a task function. Gulp instance and
callback function would be passed to it, if not configured otherwise.

You could configure the library to pass additional arguments as well.

```javascript
var compass = require('compass');

module.exports = function (gulp, callback) {
  return gulp.src('...')
    .pipe(compass())
    .dest('...')
  ;
};
```


### Module as object

Also, you could define your task module as an object.
This will allow you to provide additional configurations.

```javascript
var compass = require('compass');

module.exports = {
  dep: ['clean:styles', 'build:icons'],
  fn: function (gulp, callback) {
    return gulp.src('...')
      .pipe(compass())
      .dest('...')
    ;
  }
};
```

You will have to define your task function as `fn` parameter.
You could use `dep` parameter to define your task dependencies.

Also, you could use `nativeTask` instead of `fn` property to make your
task function executed by Gulp directly. That way, additional arguments
will not be passed to it. This feature is useful when using,
e.g. [gulp-sequence][gulp-sequence] plugin.

Your async task function should either return a stream/promise or it
should trigger the provided callback to work correctly.


## Changelog

Please see the [changelog][changelog] for list of changes.


## Feedback

If you have found a bug or have another issue with the library —
please [create an issue][new-issue].

If you have a question regarding the library or it's integration with your project —
consider asking a question at [StackOverflow][so-ask] and sending me a
link via [E-Mail][email]. I will be glad to help.

Have any ideas or propositions? Feel free to contact me by [E-Mail][email].

Cheers!


## Support

If you like this library consider to add star on [GitHub repository][repo-gh].

Thank you!


## License

The MIT License (MIT)

Copyright (c) 2016 Slava Fomin II, BETTER SOLUTIONS

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

  [changelog]:     CHANGELOG.md
  [so-ask]:        http://stackoverflow.com/questions/ask?tags=node.js,javascript
  [email]:         mailto:s.fomin@betsol.ru
  [new-issue]:     https://github.com/betsol/gulp-require-tasks/issues/new
  [gulp]:          http://gulpjs.com/
  [repo-gh]:       https://github.com/betsol/gulp-require-tasks
  [gulp-sequence]: https://github.com/teambition/gulp-sequence
