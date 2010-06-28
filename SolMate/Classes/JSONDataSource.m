//
//  JSONDataSource.m
//  SolMate
//
//  Created by Simon Free on 03/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "JSONDataSource.h"
#import "NSDate+yyyymmdd.h"

@implementation JSONDataSource
@synthesize url=_url;
@synthesize jsonObject=_jsonObject;
@synthesize delegate=_delegate;
@synthesize hasData;

- (id)initWithURLString:(NSString *)aUrl delegate:(id <JSONDataSourceDelegate>)aDelegate {
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
	_responseData = [[NSMutableData data] retain];
	NSString* qs = [self _queryString];
	NSURL* URL = [NSURL URLWithString:[NSString stringWithFormat:@"%@%@",self.url,qs]];
	NSLog(@"loading URL: %@", URL);
	NSURLRequest* request = [NSURLRequest requestWithURL:URL];
	connection = [[NSURLConnection alloc] initWithRequest:request delegate:self];
	if(self.delegate != nil) [self.delegate dataSourceDidStartLoading:self];
}
- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response {
	[_responseData setLength:0];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data {
	[_responseData appendData:data];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error {
	NSLog(@"%@", [NSString stringWithFormat:@"Connection failed: %@", [error description]]);
}

- (void)connectionDidFinishLoading:(NSURLConnection *)conn {
	[connection release];
	NSString *responseString = [[NSString alloc] initWithData:_responseData encoding:NSUTF8StringEncoding];
	[_responseData release];
	[_jsonObject release];
	_jsonObject = [[[responseString stringByEscapingUnicode] JSONValue] retain];
	NSLog(@"JSONObject: %@", [_jsonObject description]);
	hasData = YES;
	[responseString release];
	if(self.delegate != nil) [self.delegate dataSourceDidFinishLoading:self];
}

- (void)setValue:(NSString *)value forParameterKey:(NSString *)key {
	[_parameters setValue:value forKey:key];
}

- (NSString*)_queryString {
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
