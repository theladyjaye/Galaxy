//
//  GalaxySignatureOAuth.m
//  iPhone_GalaxyClientCore
//
//  Created by Adam Venturella on 1/23/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "GalaxySignatureOAuth.h"
#import "hmac.h"
#import "Base64Transcoder.h"

#define kSignatureMethod @"HMAC-SHA1"
#define kVersion         @"1.0"

@interface GalaxySignatureOAuth()
- (NSString *)buildQuery:(NSDictionary *)data order:(NSArray *)order;
@end


@implementation GalaxySignatureOAuth
@synthesize key, secret, method, realm, absoluteUrl, additionalParameters;


+ (GalaxySignatureOAuth *)signatureWithKey:(NSString *)consumer_key secret:(NSString *)consumer_secret
{
	GalaxySignatureOAuth * signature = [[GalaxySignatureOAuth alloc] init];
	signature.key    = consumer_key;
	signature.secret = consumer_secret;
	
	return [signature autorelease];
}

- (NSString *)authorizationSignature
{
	NSMutableDictionary * baseString = [NSMutableDictionary dictionary];
	
	NSString * nonce = @"1234";
	NSString * time = [NSString stringWithFormat:@"%i", (int)[[NSDate date] timeIntervalSince1970]];
	NSArray * sortedKeys;
	
	[baseString setValue:self.key forKey:@"oauth_consumer_key"];
	[baseString setValue:nonce forKey:@"oauth_nonce"];
	[baseString setValue:kSignatureMethod forKey:@"oauth_signature_method"];
	[baseString setValue:time forKey:@"oauth_timestamp"];
	[baseString setValue:@"" forKey:@"oauth_token"];
	[baseString setValue:kVersion forKey:@"oauth_version"];
	
	if(self.additionalParameters)
	{
		if([self.additionalParameters class] == [NSDictionary class])
		{
			[baseString addEntriesFromDictionary:self.additionalParameters];
		}
	}
	
	NSArray * keys = [baseString allKeys];
	sortedKeys     = [keys sortedArrayUsingSelector:@selector(localizedCaseInsensitiveCompare:)];
	
	
	NSString * string = [NSString stringWithFormat:@"%@&%@&%@", 
						 [self.method uppercaseString],
						 self.absoluteUrl,
						 [self buildQuery:baseString order:sortedKeys]];
	
	NSString *escapedString = [(NSString*)CFURLCreateStringByAddingPercentEscapes(kCFAllocatorDefault,  (CFStringRef)string, NULL,  CFSTR("?=&+:/"), kCFStringEncodingUTF8) autorelease];
	
	
	NSData * secretData     = [self.secret dataUsingEncoding:NSUTF8StringEncoding];
    NSData * baseStringData = [escapedString dataUsingEncoding:NSUTF8StringEncoding];
	
	unsigned char digest [20];
	
	hmac_sha1((unsigned char *)[baseStringData bytes], [baseStringData length], (unsigned char *)[secretData bytes], [secretData length], digest);
	
	size_t resultLength = 32;
	char base64Digest [32];

	Base64EncodeData(digest, 20, base64Digest, &resultLength);
	
	NSData * base64DigestData  = [NSData dataWithBytes:base64Digest length:resultLength];
	NSString * signatureResult = [[NSString alloc] initWithData:base64DigestData encoding:NSUTF8StringEncoding];
	NSString * signature       = [(NSString*)CFURLCreateStringByAddingPercentEscapes(kCFAllocatorDefault,  (CFStringRef)signatureResult, NULL,  CFSTR("?=&+:/"), kCFStringEncodingUTF8) autorelease];
	[signatureResult release];

	
	return [NSString stringWithFormat:@"OAuth realm=\"%@\", oauth_consumer_key=\"%@\", oauth_token=\"\", oauth_signature_method=\"%@\", oauth_signature=\"%@\", oauth_timestamp=\"%@\", oauth_nonce=\"%@\", oauth_version=\"%@\"",
			self.realm,
			[baseString valueForKey:@"oauth_consumer_key"],
			kSignatureMethod,
			signature,
			[baseString valueForKey:@"oauth_timestamp"],
			[baseString valueForKey:@"oauth_nonce"],
			kVersion];
	
	
}

- (NSString *)buildQuery:(NSDictionary *)data order:(NSArray *)order
{
	NSMutableArray * params = [NSMutableArray array];
	
	for(NSString * baseKey in order)
	{
		NSString * paramKey = [baseKey stringByAddingPercentEscapesUsingEncoding: NSUTF8StringEncoding];
		NSString * paramValue = [[data valueForKey:baseKey] stringByAddingPercentEscapesUsingEncoding: NSUTF8StringEncoding];
		[params addObject:[NSString stringWithFormat:@"%@=%@", paramKey, paramValue]];
	}
	
	return [params componentsJoinedByString:@"&"];
}

-(void) dealloc
{
	self.method = nil;
	self.key    = nil;
	self.secret = nil;
	self.realm  = nil;
	self.absoluteUrl = nil;
	self.additionalParameters = nil;
	
	[super dealloc];
}
@end
