//
//  JSONDataSource.h
//  SolMate
//
//  Created by Simon Free on 03/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "JSON.h"

@protocol JSONDataSourceDelegate;


@interface JSONDataSource : NSObject {
	NSString* _url; // the url for the json data
	NSMutableData* _responseData; // a container for received text that will be turned into a json object
	NSObject* _jsonObject; // a container for the json object, once all data is received
	NSMutableDictionary* _parameters; // a key-value list of URL parameters for the data source, i.e. ?key=value&foo=bar
	id <JSONDataSourceDelegate> _delegate; // messages will be sent to this object when events occur
	BOOL hasData; // used to determine whether the data source has loaded yet
	NSURLConnection* connection; // the url connection that loads the json from the web
}
// called by a subclass
- (id)initWithURLString:(NSString*)aUrl delegate:(id <JSONDataSourceDelegate>)aDelegate;
- (id)initWithURLString:(NSString*)aUrl;

// forces the data source to reload its json from the url
- (void)update;

// set values for url parameter keys
- (void)setValue:(NSString*)value forParameterKey:(NSString*)key;

// returns the object representing the json value of the data from the web. usually an NSArray or NSDictionary
- (NSObject*)jsonObject;

// internally used to generate the URL query string
- (NSString*)_queryString;

@property(readonly) NSString* url;
@property(retain, readwrite) id <JSONDataSourceDelegate> delegate;
@property(readonly) NSObject* jsonObject;
@property(readonly) BOOL hasData;

@end


@protocol JSONDataSourceDelegate


- (void)dataSourceDidStartLoading:(JSONDataSource*)ds;
- (void)dataSourceDidFinishLoading:(JSONDataSource*)ds;

@end
