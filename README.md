# checkdin API wrapper (php)
PHP library for interacting with the checkd.in API.

## Getting Started

1. Copy in the files in the <code>inc/</code> directory into your project.
2. Adjust your copy of <code>inc/checkdin_config.php</code> with your API credentials.
3. Instantiate <code>Checkdin\Api</code> and call the various instance methods. The return values are simple nested hashes, matching the output you see in the [developer documentation](https://developer.checkd.in/).
<pre>
  $checkdin_api = new Checkdin\Api();
  $users_page = $checkdin_api->getUsers();
  for ($user in $users_page) {
    print_r($user);
  }

  $new_user = $checkdin_api->createUser(
    array(
      'email' => 'peter@example.com',
      'identifier' => '3_85289db302dbb099',
      'first_name' => 'Peter',
      'last_name' => 'Griffin'
    )
  );
  print_r($new_user);
  // $new_user['user']['email'] is 'peter@example.com'
  // $new_user['user']['id'] is the checkd.in assigned unique identifier

</pre>

## TODO

* Working with paginated results

## Contributing to checkdin
Check out the latest development to make sure the feature hasn't been implemented or the bug hasn't been fixed yet.

Check out the issue tracker to make sure someone already hasn't requested it and/or contributed it.

1. Fork the project.

2. Start a feature/bugfix branch.

3. Commit and push until you are happy with your contribution.

4. Make sure to add tests for it. This is important so I don't break it in a future version unintentionally.

5. Run all tests by typing <pre>make</pre>

Please try not to mess with the version, or history. If you want to have your own version, or is otherwise necessary, that is fine, but please isolate to its own commit so I can cherry-pick around it.

## Copyright
Copyright © 2013 checkd.in, Laust Rud Jacobsen. See LICENSE.txt for further details.