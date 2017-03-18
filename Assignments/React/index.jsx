/* global React */
/* global ReactDOM */
/* global ajax */

/** Modules Section
 * These are modules solving in simplistic terms a single problem.
 * These will be later combined into components for actual usage.
 **/

var LogoutFormModule = React.createClass({
  onSubmit: function() {
    ajax('logout.php', null, function(responseObject) {
      if (responseObject.result === 'success') {
        this.props.onLogout();
      } else {
        alert('Failure: Could not logout');
      }
    }.bind(this));
  },
  render: function() {
    return (
      <div className="row" id="test">
        <div className="three columns u-pull-right">
          <input type="submit" value="Logout" onClick={this.onSubmit} />
        </div>
      </div>
    );
  }
});

var LoginFormModule = React.createClass({
  getInitialState: function() {
    return {
      username: 'alice',
      password: '1234'
    };
  },
  onSubmit: function() {
    ajax('login.php', { username: this.state.username,
        password: this.state.password},
        function(responseObject) {
      if (responseObject.result === 'success') {
        this.props.onLogin(responseObject.click_count);
      } else if (responseObject.result === 'failure') {
        alert('Failure: Incorrent username or password');
      } else if (responseObject.result === 'error') {
        alert("Error: " + responseObject.msg);
      }
    }.bind(this));
  },
  onUsernameChange: function(e) {
    this.setState({ username: e.target.value });
  },
  onPasswordChange: function(e) {
    this.setState({ password: e.target.value })
  },
  render: function() {
    return (
      <div>
        Username: <input type="text" onChange={this.onUsernameChange} value={this.state.username} size="36" />
        Password: <input type="password" onChange={this.onPasswordChange} value={this.state.password} size="36" />
                  <input type="submit" value="Login" onClick={this.onSubmit} />
      </div>
    );
  }
});

var ClickModule = React.createClass({
  onSubmit: function() {
    ajax('click_event.php', null, function(responseObject){
      if ('click_count' in responseObject) {
        this.props.onSetClickCount(responseObject.click_count);
      }
    }.bind(this));
  },
  render: function() {
    return (
      <div>
        Click Count: {this.props.clickCount}
        <input type="submit" value="Click Me!" onClick={this.onSubmit}/>
      </div>
    );
  }
});

/** Components Section
 * These components combine one or more modules into a single render
 * instantiation for the application.
 **/

var LoggedInComponent = React.createClass({
  render: function() {
    return (
      <div>
        <LogoutFormModule onLogout={this.props.onLogout} />
        <ClickModule clickCount={this.props.clickCount} onSetClickCount={this.props.onSetClickCount} />
      </div>
    );
  }
});

var LoggedOutComponent = React.createClass({
  render: function() {
    return (
      <div>
        <LoginFormModule onLogin={this.props.onLogin} />
      </div>
    );
  }
});

// Main instantiation of Application
var App = React.createClass({
  getInitialState: function() {
    return { 
      clickCount: null
    };
  },
  componentDidMount: function() {
    ajax('init.php', null, function(responseObject) {
      console.log(responseObject.counter);
      if ('counter' in responseObject) {
        this.setState({ clickCount: responseObject.counter });
        // Todo: Fix Counter
      }
    }.bind(this));
  },
  setClickCount: function(clickCount) {
    this.setState({ clickCount: clickCount });
  },
  onLogout: function() {
    this.setState({ clickCount: null });
  },
  render: function() {
    return this.state.clickCount !== null ? <LoggedInComponent onLogout={this.onLogout} clickCount={this.state.clickCount} onSetClickCount={this.setClickCount} />
      : <LoggedOutComponent onLogin={this.setClickCount} />;
  }
});

ReactDOM.render(<App />, document.getElementById('content'));
