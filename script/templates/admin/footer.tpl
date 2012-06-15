        </div>
    </div>
    <div id="footer"></div>
    <div id="cropper"><div class="inner"></div></div>  
    <div id="messages">
        <!-- 
        Later on, you can choose which template to use by referring to the 
        ID assigned to each template.  You'll also be able to refer
        to each template by index, so in this example, "basic-tempate" is
        index 0 and "advanced-template" is index 1.
        -->
        {literal}
        <div id="notify-template" class="ui-state-highlight">
     
            <!-- alert icon -->
            <span style="float:left; margin:2px 5px 0 0;" class="ui-icon ui-icon-info"></span>
     
            <p>#{text}</p>
        </div>
        <div id="error-template" class="ui-state-error">
            <!-- close link -->
            <a class="ui-notify-close" href="#" style="float:right">
                <span class="ui-icon ui-icon-close"></span>
            </a>     
            
            <!-- alert icon -->
            <span style="float:left; margin:2px 5px 0 0;" class="ui-icon ui-icon-alert"></span>
            
            <p>#{text}</p>
        </div>
        {/literal}
    </div>  
    <div id="loading">Kraunasi...</div>
    <div id="category-form" class="hidden">
        <label for="catname">Kategorijos pavadinimas</label>
        <input type="text" name="catname" id="catname" class="text ui-widget-content ui-corner-all" />
    </div>
    <div id="explore-city" class="hidden">
    </div>    
</div>
</body>
</html>