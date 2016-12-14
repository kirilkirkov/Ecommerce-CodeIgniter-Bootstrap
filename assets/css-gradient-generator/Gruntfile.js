module.exports = function (grunt) {

  grunt.initConfig({

    // Import package manifest
    pkg: grunt.file.readJSON("css-gradient-generator.jquery.json"),

    // Banner definitions
    meta: {
      banner: "/*\n" +
        " *  <%= pkg.title || pkg.name %>\n" +
        " *  v<%= pkg.version %>\n" +
        " *  <%= pkg.description %>\n" +
        " *  <%= pkg.homepage %>\n" +
        " *\n" +
        " *  Made by Virtuosoft:\n" +
        " *      István Ujj-Mészáros - https://github.com/istvan-ujjmeszaros\n" +
        " *      Ferenc Fapál - http://twitter.com/fwoodpaul\n" +
        " *\n" +
        " *  Thanks for the following persons:\n" +
        " *      Tibor Szász - https://github.com/kowdermeister\n" +
        " *      László Sotus - https://github.com/Lacisan\n" +
        " *\n" +
        " *  Under <%= pkg.licenses[0].type %> License\n" +
        " *  To view a copy of this license, visit\n" +
        " *  http://creativecommons.org/licenses/by-nc-sa/4.0/deed.en_US.\n" +
        " */\n"
    },

    // Concat definitions
    concat: {
      js: {
        src: ["src/css-gradient-generator.js"],
        dest: "dist/css-gradient-generator.js"
      },
      css: {
        src: ["src/css-gradient-generator.css"],
        dest: "dist/css-gradient-generator.css"
      },
      options: {
        banner: "<%= meta.banner %>"
      }
    },

    // Lint definitions
    jshint: {
      files: ["src/css-gradient-generator.js"],
      options: {
        jshintrc: ".jshintrc"
      }
    },

    // Minify definitions
    uglify: {
      js: {
        src: ["dist/css-gradient-generator.js"],
        dest: "dist/css-gradient-generator.min.js"
      },
      options: {
        banner: "<%= meta.banner %>"
      }
    },

    cssmin: {
      css: {
        src: ["dist/css-gradient-generator.css"],
        dest: "dist/css-gradient-generator.min.css"
      },
      options: {
        banner: "<%= meta.banner %>"
      }
    }
  });

  grunt.loadNpmTasks("grunt-contrib-concat");
  grunt.loadNpmTasks("grunt-contrib-jshint");
  grunt.loadNpmTasks("grunt-contrib-uglify");
  grunt.loadNpmTasks("grunt-contrib-cssmin");

  grunt.registerTask("default", ["jshint", "concat", "uglify", "cssmin"]);
  grunt.registerTask("travis", ["jshint"]);

};
