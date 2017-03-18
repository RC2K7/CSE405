/* global React */
/* global ReactDOM */
/* global ajax */

/** Modules Section
 * These are modules solving in simplistic terms a single problem.
 * These will be later combined into components for actual usage.
 **/
 
var HomeButtonModule = React.createClass({
  onSubmit: function() {
    this.props.onHomeClick();
  },
  render: function() {
    return (
      <div className="two columns">
        <input className="u-full-width" type="submit" value="Home"
          onClick={this.onSubmit} />
      </div>
      );
  }
});

var EditBlogButtonModule = React.createClass({
  getInitialState: function() {
    return {
      canEdit: false
    };
  },
  checkCanEdit: function(isLoggedIn) {
    if (isLoggedIn) {
      ajax('php/canEdit.php', { targetUser: this.props.user }, function(responseObject) {
        if ('canEdit' in responseObject) {
          if (responseObject.canEdit === 'true') {
            this.setState({ canEdit: true });
          } else {
            this.setState({ canEdit: false });
          }
        }
      }.bind(this));
    } else {
      this.setState({ canEdit: false });
    }
  },
  componentDidMount: function() {
    this.checkCanEdit(this.props.isLoggedIn);
  },
  componentWillReceiveProps: function(nextProps) {
    if (nextProps.isLoggedIn !== this.props.isLoggedIn) {
      this.checkCanEdit(nextProps.isLoggedIn);
    }
  },
  onSubmit: function() {
    this.props.onEditBlog();
  },
  render: function() {
    if (this.state.canEdit === false) {
      return <div></div>;
    } else {
      return (
        <div>
          <input className="u-full-width" type="submit" value="Edit Blog"
            onClick={this.onSubmit} />
        </div>
      );
    }
  }
});

var LogoutFormModule = React.createClass({
  onSubmit: function() {
    ajax('php/logout.php', null, function(responseObject) {
      if (responseObject.result === 'success') {
        this.props.onLogout();
      } else {
        alert('Failure: Could not logout');
      }
    }.bind(this));
  },
  render: function() {
    return (
      <div className="three columns u-pull-right">
        <input className="u-full-width" type="submit" value="Logout"
          onClick={this.onSubmit} />
      </div>
    );
  }
});

var LoginFormModule = React.createClass({
  getInitialState: function() {
    return {
      username: '',
      password: ''
    };
  },
  onSubmit: function() {
    ajax('php/login.php', { username: this.state.username,
        password: this.state.password},
        function(responseObject) {
      if (responseObject.result === 'success') {
        this.props.onLogin();
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
      <div className = "ten columns">
        <div className="three columns">
          <input className="u-full-width" type="text"
            onChange={this.onUsernameChange} placeholder="Username" size="36" />
        </div>
        <div className="three columns">
          <input className="u-full-width" type="password"
            onChange={this.onPasswordChange} placeholder="Password" size="36" />
        </div>
        <div className="two columns">
          <input className="u-full-width" type="submit" value="Login"
            onClick={this.onSubmit} />
        </div>
      </div>
    );
  }
});

var ListItemModule = React.createClass({
  viewBlog: function(user) {
    // Todo: Implement viewing ones blog
    this.props.onBlogClick(user);
  },
  render: function() {
    return <li><a href="#" onClick={this.viewBlog.bind(this, this.props.value)}>
      {this.props.value}</a></li>;
  }
});

var ListBlogsModule =  React.createClass({
  getInitialState: function() {
    return {
      posts: []
    };
  },
  componentDidMount: function() {
    ajax('php/getBlogs.php', null, function(responseObject) {
      var list = responseObject.map((data) =>
        data.username
      );
      this.setState({ posts: list });
    }.bind(this));
  },
  render: function() {
    var list = this.state.posts.map((data) =>
      <ListItemModule key={data.toString()} value={data}
        onBlogClick={this.props.onBlogClick} />
    );
    return (
      <div className="row">
        <h2>Blog Listings</h2>
        <ul>
          {list}
        </ul>
      </div>
    );
  }
});

var BlogContentModule = React.createClass({
  getInitialState: function() {
    return {
      blogText: "Loading..."
    };
  },
  componentDidMount: function() {
    ajax('php/getBlog.php', { targetUser: this.props.user }, function(responseObject) {
      if ('blogtext' in responseObject) {
        if (responseObject.blogtext === null) {
          this.setState({ blogText: '<EMPTY BLOG>' });
        } else {
          this.setState({ blogText: responseObject.blogtext });
        }
      }
    }.bind(this));
  },
  render: function() {
    return (
      <div>
        <div className="row">
          <div className="column">
            <h2>{this.props.user}'s Blog</h2>
            <pre>{this.state.blogText}</pre>
          </div>
        </div>
      </div>
    );
  }
});

var EditBlogModule = React.createClass({
  getInitialState: function() {
    return {
      blogText: 'Loading...'
    };
  },
  componentDidMount: function() {
    ajax('php/getBlog.php', { targetUser: this.props.user }, function(responseObject) {
      if ('blogtext' in responseObject) {
        if (responseObject.blogtext === null) {
          this.setState({ blogText: '<EMPTY BLOG>' });
        } else {
          this.setState({ blogText: responseObject.blogtext });
        }
      }
    }.bind(this));
  },
  onBlogTextChange: function(e) {
    this.setState({ blogText: e.target.value });
  },
  onSubmit: function() {
    ajax('php/saveBlog.php', { blogText: this.state.blogText }, function(){
      this.props.onViewBlog(this.props.user);
    }.bind(this));
  },
  render: function() {
    return (
      <div>
        <div className="row">
          <textarea className="u-full-width" onChange={this.onBlogTextChange} value={this.state.blogText} />
        </div>
        <div className="row">
          <input className="u-full-width" type="submit" value="Save Blog"
            onClick={this.onSubmit} />
        </div>
      </div>
    );
  }
});

/** Components Section
 * These components combine one or more modules into a single render
 * instantiation for the application.
 **/
 
var NavBarComponent = React.createClass({
  render: function() {
    if (this.props.isLoggedIn) {
      return (
        <div className="row">
          <HomeButtonModule onHomeClick={this.props.onHomeClick} />
          <LogoutFormModule onLogout={this.props.onLogout} />
        </div>
      );
     } else {
       return (
        <div className="row">
          <HomeButtonModule onHomeClick={this.props.onHomeClick} />
          <LoginFormModule onLogin={this.props.onLogin} />
        </div>
      );
     }
   }
 });
 
var IndexComponent = React.createClass({
  render: function() {
    return (
      <div>
        <NavBarComponent onHomeClick={this.props.onHomeClick}
          onLogin={this.props.onLogin} onLogout={this.props.onLogout}
          isLoggedIn={this.props.isLoggedIn} />
        <ListBlogsModule onBlogClick={this.props.onBlogClick} />
      </div>
    );
   }
 });
 
 var ViewBlogComponent = React.createClass({
   render: function() {
     return (
      <div>
        <NavBarComponent onHomeClick={this.props.onHomeClick}
          onLogin={this.props.onLogin} onLogout={this.props.onLogout}
          isLoggedIn={this.props.isLoggedIn} />
        <BlogContentModule user={this.props.user} />
        <EditBlogButtonModule user={this.props.user} isLoggedIn={this.props.isLoggedIn}
          onEditBlog={this.props.onEditBlog} />
      </div>
    );
   }
 });
 
 var EditBlogComponent = React.createClass({
   render: function() {
     return (
      <div>
        <NavBarComponent onHomeClick={this.props.onHomeClick}
          onLogin={this.props.onLogin} onLogout={this.props.onLogout}
          isLoggedIn={this.props.isLoggedIn} />
          <EditBlogModule user={this.props.user} isLoggedIn={this.props.isLoggedIn}
            onViewBlog={this.props.onViewBlog} />
      </div>
    );
   }
 });

// Main instantiation of Application
var App = React.createClass({
  getInitialState: function() {
    return { 
      mode: "index",
      isLoggedIn: false,
      targetBlog: null
    };
  },
  componentDidMount: function() {
    ajax('php/init.php', null, function(responseObject){
      if ('loggedIn' in responseObject) {
        if (responseObject.loggedIn === 'true') {
          this.setState({ isLoggedIn: true });
        }
      }
    }.bind(this));
  },
  onLogin: function() {
    this.setState({ isLoggedIn: true });
  },
  onLogout: function() {
    this.setState({ isLoggedIn: false });
    if (this.state.mode === 'edit') {
      this.onViewBlog(this.state.targetBlog);
    }
  },
  onViewHome: function() {
    this.setState({ mode: 'index' });
  },
  onViewBlog: function(blog) {
    this.setState({ targetBlog: blog, mode: 'view' });
  },
  onEditBlog: function() {
    this.setState({ mode: 'edit' });
  },
  render: function() {
    if (this.state.mode === 'index') {
      return <IndexComponent onHomeClick={this.onViewHome}
        onBlogClick={this.onViewBlog} onLogin={this.onLogin}
        onLogout={this.onLogout} isLoggedIn={this.state.isLoggedIn} />
    } else if (this.state.mode === 'view') {
      return <ViewBlogComponent onHomeClick={this.onViewHome}
        user={this.state.targetBlog} onLogin={this.onLogin}
        onLogout={this.onLogout} isLoggedIn={this.state.isLoggedIn}
        onEditBlog={this.onEditBlog} />
    } else if (this.state.mode === 'edit') {
      return <EditBlogComponent onHomeClick={this.onViewHome}
        user={this.state.targetBlog} onLogin={this.onLogin}
        onLogout={this.onLogout} isLoggedIn={this.state.isLoggedIn}
        onViewBlog={this.onViewBlog} />
    }
  }
});

ReactDOM.render(<App />, document.getElementById('content'));
