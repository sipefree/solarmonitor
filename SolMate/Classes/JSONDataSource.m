//
//  JSONDataSource.m
//  SolMate
//
//  Created by Simon Free on 03/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import "JSONDataSource.h"
#import "NSDate+yyyymmdd.h"

@implementation JSONDataSource
@synthesize url=_url;
@synthesize jsonObject=_jsonObject;
@synthesize delegate=_delegate;
@synthesize hasData;

- (id)initWithURLString:(NSString *)aUrl delegate:(id <JSONDataSourceDelegate>)aDelegate {
	// this method is called by a subclass giving the URL for its data
	if((self = [super init]) != nil) {
		_url = aUrl;
		_parameters = [[NSMutableDictionary alloc] init];
		_delegate = aDelegate;
		hasData = NO;
	}
	return self;
}
- (id)initWithURLString:(NSString*)aUrl {
	return [self initWithURLString:aUrl delegate:nil];
}
- (void)update {
	// create a new container for data received
	_responseData = [[NSMutableData data] retain];
	
	// generate the url query string
	NSString* qs = [self _queryString];
	
	// create the url string from the base url and the query string
	NSURL* URL = [NSURL URLWithString:[NSString stringWithFormat:@"%@%@",self.url,qs]];
	
	NSLog(@"loading URL: %@", URL);
	
	// initiate the url request
	NSURLRequest* request = [NSURLRequest requestWithURL:URL];
	connection = [[NSURLConnection alloc] initWithRequest:request delegate:self];
	
	// send a message to the delegate informing it that data will be received
	// this is used to start activity indicators animating etc
	if(self.delegate != nil) [self.delegate dataSourceDidStartLoading:self];
}
- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response {
	// boilerplate code for the url connection
	[_responseData setLength:0];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data {
	// some data was received, it should be appended to the response container
	[_responseData appendData:data];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error {
	// the app will probably crash anyway
	NSLog(@"%@", [NSString stringWithFormat:@"Connection failed: %@", [error description]]);
}

- (void)connectionDidFinishLoading:(NSURLConnection *)conn {
	// release the url connection, as it is no longer needed
	[connection release];
	
	// create a string from the data received
	NSString *responseString = [[NSString alloc] initWithData:_responseData encoding:NSUTF8StringEncoding];
	
	// release all the old data
	[_responseData release];
	_responseData = nil;
	[_jsonObject release];
	
	// generate the JSON object from the string
	_jsonObject = [[[responseString stringByEscapingUnicode] JSONValue] retain];
	NSLog(@"%@ JSONObject: %@", [[self class] description], [_jsonObject description]);
	hasData = YES;
	
	// the string is no longer needed, as we have the object now
	[responseString release];
	
	// inform the delegate that a json object is available for it
	if(self.delegate != nil) [self.delegate dataSourceDidFinishLoading:self];
}

- (void)setValue:(NSString *)value forParameterKey:(NSString *)key {
	// simple mapping to the query string dictionary
	[_parameters setValue:value forKey:key];
}

- (NSString*)_queryString {
	// generate the query string
	NSMutableString* qs = [NSMutableString stringWithString:@"?"];
	NSString* key;
	NSString* value;
	for (key in _parameters) {
		value = [_parameters valueForKey:key];
		[qs appendFormat:@"%@=%@&",key,value];
	}
	return qs;
}

- (void)dealloc {
	[_jsonObject release];
	[_parameters release];
    [super dealloc];
}

@end
