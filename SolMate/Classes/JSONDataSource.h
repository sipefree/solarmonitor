//
//  JSONDataSource.h
//  SolMate
//
//  Created by Simon Free on 03/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "JSON.h"

@protocol JSONDataSourceDelegate;


@interface JSONDataSource : NSObject {
	NSString* _url;
	NSMutableData* _responseData;
	NSObject* _jsonObject;
	NSMutableDictionary* _parameters;
	id <JSONDataSourceDelegate> _delegate;
	BOOL hasData;
	NSURLConnection* connection;
}
- (id)initWithURLString:(NSString*)aUrl delegate:(id <JSONDataSourceDelegate>)aDelegate;
- (id)initWithURLString:(NSString*)aUrl;
- (void)update;
- (void)setValue:(NSString*)value forParameterKey:(NSString*)key;
- (NSObject*)jsonObject;
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
