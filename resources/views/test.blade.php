<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="tab-interface">
        <div role="tablist" aria-label="Sample Tabs">
          <span
            role="tab"
            aria-selected="true"
            aria-controls="panel-1"
            id="tab-1"
            tabindex="0">
            First Tab
          </span>
          <span
            role="tab"
            aria-selected="false"
            aria-controls="panel-2"
            id="tab-2"
            tabindex="-1">
            Second Tab
          </span>
          <span
            role="tab"
            aria-selected="false"
            aria-controls="panel-3"
            id="tab-3"
            tabindex="-1">
            Third Tab
          </span>
        </div>
        <div id="panel-1" role="tabpanel" tabindex="0" aria-labelledby="tab-1">
          <p>Content for the first panel</p>
        </div>
        <div
          id="panel-2"
          role="tabpanel"
          tabindex="0"
          aria-labelledby="tab-2"
          class="display-none">
          <p>Content for the second panel</p>
        </div>
        <div
          id="panel-3"
          role="tabpanel"
          tabindex="0"
          aria-labelledby="tab-3"
          class="display-none">
          <p>Content for the third panel</p>
        </div>
      </div>
      
</body>
</html>